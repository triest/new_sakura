<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\SendMessageToUser;
    use App\Models\Dialog;
    use App\Events\NewMessage;
    use App\Models\Message;
    use App\Models\Lk\User;
    use App\Service\ContactService;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    class ContactController extends Controller
    {
        //
        public function index()
        {
            return view('anket.messages');
        }

        public function get(ContactService $contactService)
        {
            return response()->json($contactService->getContacts());
        }


        public function getMessagesFor($id, ContactService $contactService)
        {
            $user = User::get($id);
            if ($user == null) {
                return null;
            }
            $messages = $contactService->getMessagesFor($user);
            return response()->json($messages);
        }

        public function send(SendMessageToUser $request)
        {
            $user = User::get($request->contact_id);
            if ($user == null) {
                return null;
            }
            $message = $user->sendMessage($request->text);
            return response()->json($message);
        }

    }
