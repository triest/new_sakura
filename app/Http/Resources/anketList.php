<?php

    namespace App\Http\Resources;

    use App\Models\Lk\User;
    use Illuminate\Http\Resources\Json\JsonResource;

    class anketList extends JsonResource
    {
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request $request
         * @return array
         */
        public function toArray($request)
        {
           // $user = User::get($this->id);

            return [
                    'id' => $this->id,
                    'name' => $this->name,
                    'profile_url' => $this->profile_url,
                    'age' => $this->age
            ];
        }
    }
