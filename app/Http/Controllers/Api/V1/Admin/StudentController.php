<?php

namespace App\Http\Controllers\Api\V1\Admin;
   
use App\Http\Controllers\Api\V1\Admin\BaseController as BaseController;
use App\Models\Student;
use App\Models\MyAward;
use App\Models\Award;
use App\Models\Reading;
use App\Models\UserIsMember;
use App\Models\Membership;
use App\Models\Payement;
use App\Models\Setting;
use App\Models\Agegroup;
use App\Models\Classe;
use App\Models\Level;
use App\Models\Langue;
use App\Models\Subject;
use App\Models\Genre;
use App\Models\Score;
use App\Models\Theme;
use App\Models\Ressource;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFolderRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\User;

class StudentController extends BaseController
{
    use MediaUploadingTrait;


    public function signin(Request $request)
    {
        $student = Student::query()->where("username", strtolower($request->username))->where("password", $request->password)->with("age", "langue")->get();
        if(!$student->isEmpty()){ 
            return $this->sendResponse($student, 'Success');
        } 
        else{ 
            return $this->sendResponse($student, 'Error');
        }  
    }

    public function getUserOrClass(Request $request)
    {
        $student = Student::query()->where("id", $request->id)->get()[0];
        $userId = $student->user_id;
        //return $userId;
        if($userId){
            $student = Student::query()->where("id", $request->id)->with("user")->get()[0];
            return $this->sendResponse($student, 'Success', 'Parent');
        }
        else{
            $student = Student::query()->where("id", $request->id)->with("classe")->get()[0];
            return $this->sendResponse($student, 'Success', 'School');
        }
        
    }


    public function getmemebershipforparent(Request $request)
    {
        $member = UserIsMember::query()->where("student_id", $request->id)->get();
        return $this->sendResponse($member, 'Success', 'Member');
    }

    public function getmemebershipforclass(Request $request)
    {
        $member = UserIsMember::query()->where("classe_id", $request->id)->get();
        return $this->sendResponse($member, 'Success', 'Member');
    }


    public function getsubjects()
    {
        $subjects = Subject::all();
        return $this->sendResponse($subjects, 'Success', 'Subjects');
    }

    public function getgenres()
    {
        $genres = Genre::all();
        return $this->sendResponse($genres, 'Success', 'Genres');
    }


    public function getthemes()
    {
        $themes = Theme::all();
        return $this->sendResponse($themes, 'Success', 'Themes');
    }


    public function getlevels(Request $request)
    {
        $levels = Level::query()->where("agegroup_id", $request->id)->get();
        return $this->sendResponse($levels, 'Success', 'Levels');
    }


    public function getagegroup(Request $request)
    {
        $ages = Agegroup::query()->where("id", $request->id)->get();
        return $this->sendResponse($ages, 'Success', 'Ages');
    }

    public function getleveledressources(Request $request)
    {
        $ressources = Ressource::query()->where("langue_id", $request->langue)->where("level_id", $request->level)->where("agegroup_id", $request->age)->with("agegroup", "genre", "subject", "theme", "level", "langue")->get();
        return $this->sendResponse($ressources, 'Success', 'Ressources');
    }

    public function getsubjectsressources(Request $request)
    {
        //return $request;
        $ressources = Ressource::query()->where("langue_id", $request->langue)->where("agegroup_id", $request->age)->orWhereNull('agegroup_id')->with("agegroup", "genre", "subject", "theme", "level", "langue")->get();
        $items = array();
        foreach ($ressources as $ressource) {
            if($ressource->subject_id == $request->subject_id){
                array_push($items,$ressource);
            }
        }
        return $this->sendResponse($items, 'Success', 'Ressources');
    }


    public function getthemesressources(Request $request)
    {
        //return $request;
        $ressources = Ressource::query()->where("agegroup_id", $request->age)->orWhereNull('agegroup_id')->with("agegroup", "genre", "subject", "theme", "level", "langue")->get();
        $items = array();
        foreach ($ressources as $ressource) {
            if($ressource->theme_id == $request->theme_id && $ressource->langue_id == $request->langue){
                array_push($items,$ressource);
            }
        }
        return $this->sendResponse($items, 'Success', 'Ressources');
        //return $this->sendResponse($ressources, 'Success', 'Ressources');
    }

    public function getgenresressources(Request $request)
    {
        //return $request;
        $ressources = Ressource::query()->where("agegroup_id", $request->age)->orWhereNull('agegroup_id')->with("agegroup", "genre", "subject", "theme", "level", "langue")->get();
        //$ressources = Ressource::query()->where("langue_id", $request->langue)->where("genre_id", $request->genre_id)->where("agegroup_id", $request->age)->with("agegroup", "genre", "subject", "theme", "level", "langue")->get();
        $items = array();
        foreach ($ressources as $ressource) {
            if($ressource->genre_id == $request->genre_id && $ressource->langue_id == $request->langue){
                array_push($items,$ressource);
            }
        }
        return $this->sendResponse($items, 'Success', 'Ressources');
    }

    public function getageressources(Request $request)
    {
        //return $request;
        $ressources = Ressource::query()->where("agegroup_id", $request->age_id)->orWhereNull('agegroup_id')->with("agegroup", "genre", "subject", "theme", "level", "langue")->get();
        //return $this->sendResponse($ressources, 'Success', 'Ressources');
        $items = array();
        foreach ($ressources as $ressource) {
            if($ressource->langue_id == $request->langue){
                array_push($items,$ressource);
            }
        }
        return $this->sendResponse($items, 'Success', 'Ressources');
    }




    public function countressources(Request $request)
    {   

        $ressources = Level::query()->where("agegroup_id", $request->age)->with("level")->count();
        return $this->sendResponse($ressources, 'Success', 'Ressources');
    }

    public function getressource(Request $request)
    {   

        $ressources = Ressource::query()->where("id", $request->id)->with("agegroup", "genre", "subject", "theme", "level", "langue")->get();
        return $this->sendResponse($ressources, 'Success', 'Ressources');
    }



    public function getscore(Request $request)
    {
        $score = Score::query()->where("student_id", $request->id)->get();
        return $this->sendResponse($score, 'Success', 'Score');
    }


    public function getawardsall()
    {
        $awards = Award::all();
        return $this->sendResponse($awards, 'Success', 'Awards');
    }


    public function getawards(Request $request)
    {
        $awards = MyAward::query()->where("student_id", $request->id)->with("award")->get();
        return $this->sendResponse($awards, 'Success', 'My awards');
    }


    public function addaward(Request $request)
    {
        $award = new MyAward;
        $award->student_id = $request->student;
        $award->award_id = $request->award;
        $award->save();
        if($award){
            return $this->sendResponse($award, 'Success', 'My award');
        }
    }


    public function addreading(Request $request)
    {
        $reading = new Reading;
        $reading->status = $request->status;
        $reading->student_id = $request->student;
        $reading->ressource_id = $request->ressource;
        $reading->save();
        if($reading){
            return $this->sendResponse($reading, 'Success', 'My award');
        }
    }





    public function addscore(Request $request)
    {
        $score = Score::query()->where("student_id", $request->student_id)->get()[0];
        //return $score;
        $scoreId = $score->id;
        $oldscore = $score->points;
        $score = Score::query()->find($scoreId);
        $score->points = $oldscore + $request->points;
        $score->update();
        if($score){
            return $this->sendResponse($score, 'Success', 'Success');
        }
        else{
            return $this->sendResponse($score, 'Success', 'Error');
        }
        
    }


    public function getreading(Request $request)
    {
        $reading = Reading::query()->where("student_id", $request->student)->get()[0];
        return $this->sendResponse($reading, 'Success', 'Lecture');
    }


    public function countreading(Request $request)
    {
        $ressources = Ressource::query()->where("agegroup_id", $request->age)->orWhereNull('agegroup_id')->with("agegroup", "genre", "subject", "theme", "level", "langue")->get();
        //return $this->sendResponse($ressources, 'Success', 'Ressources');
        $items = 0;
        foreach ($ressources as $ressource) {
            if($ressource->langue_id == $request->langue){
                $items = $items+1;
            }
        }
        return $this->sendResponse($items, 'Success', 'Ressources');
    }



}
