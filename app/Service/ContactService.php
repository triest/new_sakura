<?php
    /**
     * Created by PhpStorm.
     * User: triest
     * Date: 23.08.2020
     * Time: 17:20
     */

    namespace App\Service;


    use App\Models\Dialog;
    use App\Models\Lk\User;
    use App\Models\Message;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    class ContactService
    {

        public function getContacts(User $user = null)
        {
            if ($user == null) {
                $user = Auth::user();
            }



            if ($user == null) {
                return null;
            }

            $dialogs = Dialog::select('id', 'my_id', 'other_id')
                    ->where('my_id', $user->id)->get();
            $contacts = [];
            foreach ($dialogs as $dialog) {
                $other = $dialog->other_id;
                $user = DB::table('users')
                        ->select('*')
                        ->where('users.id', $other)->first();
                // $user=DB::table('users')->join('gitls')
                array_push($contacts, $user);
            }
            return $contacts;
        }

        public function getMessagesFor(User $user = null)
        {
            if ($user == null) {
                $user = Auth::user();
            }

            if ($user == null) {
                return null;
            }

            Message::where('from', $user->id)->where('to', $user->id)
                    ->update(['readed' => true]);
            $messages = Message::where('from', $user->id)->orWhere('to', $user->id)->get();
            return $messages;
        }
        public function getUnreaded(User $user=null){
            if ($user == null) {
                $user = Auth::user();
            }

            if ($user == null) {
                return false;
            }

            return Message::where('to', $user->id)->where(['readed'=>false])->orWhere('to', $user->id);
        }
    }
