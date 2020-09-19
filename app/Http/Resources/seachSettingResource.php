<?php

    namespace App\Http\Resources;

    use Illuminate\Http\Resources\Json\JsonResource;

    class seachSettingResource extends JsonResource
    {
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request $request
         * @return array
         */


        public function toArray($request)
        {
            return [
                    "anket" => $this["anket"],
                    "targets" => $this["targets"],
                    "selectedTargets" => $this["selectedTargets"],
                    "interests" => $this["interests"],
                    "selectedInterest" => $this["selectedInterest"],
                    "appearance" => $this["apperance"],
                    "relations" => $this["relations"],
                    "children" => $this["children"],
                    "searchSettings" => $this["sechSettings"],
                    "smoking" => $this["smoking"]
            ];
        }
    }
