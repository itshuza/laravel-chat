<?php

namespace App\Livewire;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;
use App\Models\chatmessage;
use App\Events\MessageSent;


class Chat extends Component
{
    public $users;
    public $selecteduser;
    public $newMessage;
    public $messages;
    public $loginID;
    public function mount()
    {
        $this->users = User::whereNot("id", Auth::id())->latest()->get();
        $this->selecteduser = $this->users->first();
        $this->loadMessage();
        $this->loginID=Auth::id();

       
    }
    public function selectUser($id)
    {
        $this->selecteduser = User::find($id);
        $this->loadMessage();
    }
    public function loadMessage(){
         $this->messages = chatmessage::query()
            ->where(function ($q) {
                $q->where("sender_id", Auth::id())
                    ->where("receiver_id", $this->selecteduser->id);
            })
            ->orwhere(function ($q) {
                $q->where("sender_id", $this->selecteduser->id)
                    ->where("receiver_id", Auth::id());
            })
               ->get();
    }
    public function submit(): void
    {
        if (!$this->newMessage)
            return;

        $message =chatmessage::create([
            "sender_id" => Auth::id(),
            "receiver_id" => $this->selecteduser->id,
            "message" => $this->newMessage
        ]);
        $this->messages->push($message);
        $this->newMessage = '';
        broadcast(new MessageSent($message)); 
    }
    public function getListeners(){
        return[
            "echo-private:chat.{$this->loginID},MessageSent"=>"newchatmessagenotification"
            
        ];
    } 
    public function newchatmessagenotification($message){
         if($message['sender_id']===$this->selecteduser->id){
            $messageObj=chatmessage::find($message['id']);
            $this->messages->push($message);
         }
    }
    public function render()
    {
        return view('livewire.chat');
    }
}
