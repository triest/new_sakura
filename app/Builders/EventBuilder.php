<?php
    /**
     * Created by PhpStorm.
     * User: triest
     * Date: 22.08.2020
     * Time: 22:54
     */

    namespace App\Builders;


    use App\Models\City;
    use App\Models\Event;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth;

    class EventBuilder
    {

        private $name;
        private $begin;
        private $description;
        private $user = null;
        private $max_people;
        private $min_people;
        private $end_applications = null;
        private $place;
        private $city_id;

        /**
         * @param mixed $name
         */
        public function setName($name): void
        {
            $this->name = $name;
        }

        /**
         * @param mixed $begin
         */
        public function setBegin($begin): void
        {
            $this->begin = $begin;
        }

        /**
         * @param mixed $description
         */
        public function setDescription($description): void
        {
            $this->description = $description;
        }

        /**
         * @param mixed $user
         */
        public function setUser($user): void
        {
            $this->user = $user;
        }

        /**
         * @param mixed $max_people
         */
        public function setMaxPeople($max_people): void
        {
            $this->max_people = $max_people;
        }

        /**
         * @param mixed $min_piople
         */
        public function setMinPiople($min_piople): void
        {
            $this->min_piople = $min_piople;
        }

        /**
         * @param mixed $end_applications
         */
        public function setEndApplications($end_applications): void
        {
            $this->end_applications = $end_applications;
        }

        /**
         * @param mixed $place
         */
        public function setPlace($place): void
        {
            $this->place = $place;
        }

        /**
         * @param mixed $city_id
         */
        public function setCityId($city_id): void
        {
            $this->city_id = $city_id;
        }

        public function setCity(City $city): void
        {
            $this->city_id = $city->id;
        }

        public function getResult()
        {
            $event = new Event();
            $event->place = $this->place;
            $event->name = $this->name;
            $event->city_id = $this->city_id;
            $event->max_people = $this->max_people;
            $event->min_people = $this->min_people;
            $event->description = $this->description;
            if (!Carbon::createFromTimeString($this->begin)->isFuture()) {
                return "Дата начала в прошлом";
            }
            $event->begin = $this->begin;

            if ($this->end_applications != null && !Carbon::createFromTimeString($this->end_applications)->isFuture()) {
                return "Дата окончания в прошлом";
            }
            $event-> end_applications = $this->end_applications;

            if ($this->user == null) {
                $this->user = Auth::user();
            }
            $event->user()->associate($this->user);
            $event->save();

            return $event;
        }
    }