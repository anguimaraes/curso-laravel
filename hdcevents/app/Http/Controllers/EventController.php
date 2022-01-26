<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/* Chamando o model que eu criei do Event aqui pro controlle para eu poder ter acesso ao banco de dados*/
use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    public function index(){

        $search = request('search');

        if($search){

            $events = Event::Where([
                ['title', 'like', '%'.$search.'%']
            ])->get();

        }else{
        /*Selecionando todos os dados do banco "select * from" */
        $events = Event::all();
        }


        return view('Welcome', ['events' => $events, 'search' => $search]);
    }

    public function create(){
        return view('events.create');
    }

    public function store(Request $request){

        $event = new Event;

        $event->title = $request->title;
        $event->date = $request->date;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->items = $request->items;

        //Image Upload
        if($request->hasFile('image') && $request->file('image')->isValid()){

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now"));

            $requestImage->move(public_path('img/events'), $imageName);

            $event->image = $imageName;
            
        }

        /*Preenchendo o campo user_id que foi criado na tabela events*/
        $user = auth()->user();
        $event->user_id = $user->id;

        $event->save();

        /* usando o ->with eu coloco uma mensagem para o usuário antes de redirecionar para o home ('/')*/ 
        return redirect('/')->with('msg', 'Evento criado com sucesso!');
    }

    public function show($id){

        $event = Event::findOrFail($id);

        /*Criar verificações para o usuário não poder participar do mesmo evento que ja esta participando */
        $user = auth()->user();
        $hasUserJoined = false;

        if($user){

            $userEvents = $user->eventsAsParticipant->toArray();

                foreach($userEvents as $userEvent){
                    if($userEvent['id'] == $id){
                        $hasUserJoined = true;
                    }
                }
        }

        /*Descobrindo quem é o dono do evento */
        $eventOwner = User::where('id', $event->user_id)->first()->toArray();


        return view('events.show', ['event' => $event, 'eventOwner' => $eventOwner, 'hasUserJoined' => $hasUserJoined]);
    }

    public function dashboard(){

        $user = auth()->user();

        $events = $user->events;

        $eventsAsParticipant = $user->eventsAsParticipant;

        return view('events.dashboard', ['events' => $events, 'eventsasparticipant' => $eventsAsParticipant]);
    }

    public function destroy($id){
        Event::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Evento excluido com sucesso!');
    }

    public function edit($id){

        $user = auth()->user();

        $event = Event::findOrFail($id);

        /*Não permitindo que alguem acesse a edição de eventos sem ser o dono do evento */
        if($user->id != $event->user_id){
            return redirect('/dashboard');
        }

        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request){

        $data = $request->all();

        //Image Upload
        if($request->hasFile('image') && $request->file('image')->isValid()){

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now"));

            $requestImage->move(public_path('img/events'), $imageName);

            $data['image'] = $imageName;
            
        }

        Event::findOrFail($request->id)->update($data);

        return redirect('/dashboard')->with('msg', 'Evento editado com sucesso!');
    }

    /*Criando uma nova action de Join para o confirmar presença */
    public function joinEvent($id) {
        
        $user = auth()->user();

        $user->eventsAsParticipant()->attach($id);

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Sua presença foi confirmada no evento ' . $event->title);
    }

    public function leaveEvent($id){
        $user = auth()->user();

        $user->eventsAsParticipant()->detach($id);

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Você saiu com sucesso do evento: ' . $event->title);
    }
}
