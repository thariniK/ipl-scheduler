<?php


class ScheduleMatches {

    protected $teams;
    protected $scheduled_matches;
    protected $start_date;
    protected $combinations;

    /**
     * ScheduleMatches constructor.
     * @param $start_date
     * @param $teams
     */
    public function __construct($start_date, $teams) {
        $this->teams = $teams;
        $this->scheduled_matches = [];
        $this->start_date = $start_date;
    }


    /**
     * Check if given date is a weekend
     * @param $date
     * @return bool
     */
    private function isDateWeekend($date) {
        return date('N', strtotime($date)) >= 6;
    }


    /**
     * Add one day to a given date
     * @param $date
     * @return date string
     */
    private function addDate($date) {
        return date('Y-m-d', strtotime($date. ' + 1 days'));
    }


    /**
     * Schedule matches from start date
     * @return array
     */
    public function schedule() {
        $date = $this->start_date;

        $combinations = $this->getTeamCombinationWithoutOverlap();
        $combinations = array_values($combinations);

        for ($i = 0; $i < count($combinations); $i++) {

            if($this->isDateWeekend($date)) {

                if(!isset($this->scheduled_matches[$date])) {
                    $this->scheduled_matches[$date] = [];
                }

                $this->scheduled_matches[$date][count($this->scheduled_matches[$date])] = [
                    'home' => $combinations[$i]['home'],
                    'away' => $combinations[$i]['away']
                ];

                if(count($this->scheduled_matches[$date]) == 2) {
                    $date = $this->addDate($date);
                }
            } else {

                $this->scheduled_matches[$date] = [];
                $this->scheduled_matches[$date][count($this->scheduled_matches[$date])] = [
                    'home' => $combinations[$i]['home'],
                    'away' => $combinations[$i]['away']
                ];

                $date = $this->addDate($date);
            }
        }

        return $this->scheduled_matches;
    }


    /**
     * Generate unique combinations for matches
     * @return array
     */
    private function getTeamCombinationWithoutOverlap() {

        $combination = [];
        $teams = array_values($this->teams);
        $team_count = count($teams);

        for ($i = 0; $i < $team_count * 2; $i++) {
            for ($j = 0; $j < $team_count / 2; $j++) {

                $home = $teams[($i + $j) % ($team_count - 1)];
                $away = $teams[($team_count - 1 - $j + $i) % ($team_count - 1)];

                // Last team remains in the same position while the others are rotated
                if ($j == 0) {
                    $away = $teams[$team_count - 1];
                }

                // from i half interchange the position of teams in i, to get both home and away matches
                if ($i < ($team_count - 1)) {
                    $combination[$home.$away] = [
                        'home' => $home,
                        'away' => $away
                    ];
                } else { //interchange the place of teams from half
                    $combination[$away.$home] = [
                        'home' => $away,
                        'away' => $home
                    ];
                }
            }
        }
        return $combination;
    }
}