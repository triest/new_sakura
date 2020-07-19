<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\SendMessageToUser;
    use App\Models\Dialog;
    use App\Events\NewMessage;
    use App\Models\Message;
    use App\Models\Lk\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    class ContactController extends Controller
    {
        //
        public function index(Request $request)
        {
            return view('anket.messages');
        }

        public function get()
        {

            $dialogs = Dialog::select('id', 'my_id', 'other_id')
                    ->where('my_id', Auth::user()->id)->get();


            $contacts = [];
            foreach ($dialogs as $dialog) {
                $other = $dialog->other_id;
                $user = DB::table('users')
                        ->select('*')
                        ->where('users.id', $other)->first();
                // $user=DB::table('users')->join('gitls')
                array_push($contacts, $user);
            }

            return response()->json($contacts);
        }


        public function getMessagesFor($id)
        {
            Message::where('from', $id)->where('to', auth()->id())
                    ->update(['readed' => true]);
            // mark all messages with the selected contact as read
            Message::where('from', $id)->where('to', auth()->id());
            // get all messages between the authenticated user and the selected user
            $messages = Message::where('from', $id)->orWhere('to', $id)->get();

            return response()->json($messages);
        }

        public function send(SendMessageToUser $request)
        {
            $message = new Message();
            $message->from = auth()->id();
            $message->to = $request->contact_id;
            $message->text = $request->text;
            $message->save();


            $user = Auth::user();
            $id2 = $request->contact_id;
            $dialog = Dialog::select(['id', 'my_id', 'other_id'])
                    ->where('my_id', $user->id)->where('other_id',
                            $id2)->first();
            if ($dialog == null) {
                $dialog3 = new Dialog();
                $dialog3->my_id = $user->id;
                $dialog3->other_id = $id2;
                $dialog3->save();
            }
            $dialog2 = Dialog::select(['id', 'my_id', 'other_id'])
                    ->where('other_id', $user->id)->where('my_id',
                            $id2)->first();
            if ($dialog2 == null) {
                $dialog4 = new Dialog();
                $dialog4->other_id = $user->id;
                $dialog4->my_id = $id2;
                $dialog4->save();
            }
            broadcast(new NewMessage($message));
            /*   $user2 = User::findById($id2);
              if ($user2 != null && !$user2->isOnline()) {
                  $this->sendNotification($request->text, $user2, $user);
              }
 */
            return response()->json($message);
        }

    }
