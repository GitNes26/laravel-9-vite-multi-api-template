<?php
namespace App\Http\Controllers\imm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ObjResponse;
use App\Models\imm\UserProfile;
use App\Models\imm\UserData;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\imm\UserDiseases;
use App\Models\imm\UserViolence;
use App\Http\Controllers\imm\UserProceedingsImmController;
use App\Http\Controllers\imm\UserComunityImmController;
use App\Models\imm\Services;
use App\Models\imm\UserViolenceField;
use App\Models\imm\UserDisabilities;
use App\Models\imm\UserProfilesAdicttions;
use App\Models\imm\UserServicesReferences;



use App\Models\imm\UserProfilesMedAdi;
use App\Models\imm\UserService;
use Carbon\Carbon;

use PhpParser\Node\Stmt\Return_;

class UserProfileImmController extends Controller
{
    public function createData(Request $request, Response $response,int $id=null)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $userData = UserData::where("id", $id)->first();
            if (!$userData) {
                $userData = new UserData();
            }
            $userData->name = $request->name;
            $userData->lastName = $request->lastName;
            $userData->secondName = $request->secondName;
            $userData->sex = $request->sex;
            $userData->gender_id = intval($request->gender_id);
            $userData->birthdate = Carbon::parse($request->birthdate)->format('Y-m-d');
            $userData->age = $request->age;
            $userData->telephone = $request->telephone;
            $userData->email = $request->email;
            $userData->civil_status_id = intval($request->civil_status_id);
            $userData->numberchildrens = $request->numberchildrens;
            $userData->numberdaughters = $request->numberdaughters;
            $userData->pregnant = $request->pregnant;

            $userData->save();



           $procceding = new UserProceedingsImmController();
            $comunity = new UserComunityImmController();
            $procceding->create($request,$response,$userData->id,$id);
            $comunity->create($request,$response,$userData->id,$id);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | datos de usuario registrado.';
            $response->data["alert_text"] = 'UserData registrada';
            $response->data["result"] = $userData->id;
        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function createProfile(Request $request, Response $response,int $id)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $UserProfile = UserProfile::where("user_datageneral_id", $id)->first();
            if (!$UserProfile) {
                $UserProfile = new UserProfile();
                $UserProfile->user_datageneral_id = $id;
            }
            else{
                UserDiseases::where("user_datageneral_id",$id)->delete();
                UserDisabilities::where("user_datageneral_id",$id)->delete();
                UserProfilesMedAdi::where("user_profiles_id",$UserProfile->id)->delete();
                UserProfilesAdicttions::where("user_profiles_id",$UserProfile->id)->delete();
                
            }


            $UserProfile->activity_id = $request->activity_id;
            $UserProfile->sourceofincome = $request->sourceofincome;
            $UserProfile->workplace_id = $request->workplace_id;
            $UserProfile->entry_time = $request->entry_time;
            $UserProfile->departure_time = $request->departure_time;

            $UserProfile->training_id = $request->training_id;
            $UserProfile->finish = $request->finish;
            $UserProfile->wantofindwork = $request->wantofindwork;
            $UserProfile->wanttotrain = $request->wanttotrain;
            $UserProfile->wantocontinuestudying = $request->wantocontinuestudying;
            $UserProfile->household_id = $request->household_id;
            // $UserProfile->medicalservice_id = $request->medicalservice_id;
            // $UserProfile->addiction_id = $request->addiction_id;
            $UserProfile->caseviolence = $request->caseviolence;

            $UserProfile->save();

            if (is_array($request->diseases)) {

                    foreach ($request->diseases as $key => $disease) {
                    UserDiseases::create([
                        'user_datageneral_id' => $id,
                        'diseas_id'=> $disease["value"],
                        'origin_id'=> $disease["origin_id"]
                    ]);

                    }
            }
            if (is_array($request->disabilities)) {
                foreach ($request->disabilities as $key => $disabilitie) {
                    UserDisabilities::create([
                     'user_datageneral_id' => $id,
                     'disability_id'=> $disabilitie["value"],
                     'origin_id'=> $disabilitie["origin_id"]

                 ]);
            }

            }
            if (is_array($request->medicalservice_id)) {
                foreach ($request->medicalservice_id as $key => $medicalservice) {
                    UserProfilesMedAdi::create([
                     'user_profiles_id' => $UserProfile->id,
                     'medicalservice_id'=> $medicalservice["value"],

                 ]);
            }
        }
            if (is_array($request->addiction_id)) {
                foreach ($request->addiction_id as $key => $addictions) {
                    UserProfilesAdicttions::create([
                     'user_profiles_id' => $UserProfile->id,
                     'addiction_id'=> $addictions["value"],

                 ]);
            }
            }
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | perfil registrado.';
            $response->data["alert_text"] = 'Profile registrado';
            $response->data["result"] = $id;
        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function createViolence(Request $request, Response $response,int $id)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $userViolence = UserViolence::where("user_datageneral_id", $id)->first();
            if (!$userViolence) {

                $userViolence = new UserViolence();
                $userViolence->user_datageneral_id = $id;
            }
            else{
                UserViolenceField::where("user_violences_id",$userViolence->id)->delete();

            }
            // $userViolence->typesviolence_id = intval($request->typesviolence_id);
            // $userViolence->fieldsviolence_id = intval($request->fieldsviolence_id);
            $userViolence->lowefecct = $request->lowefecct;
            $userViolence->narrationfacts = $request->narrationfacts;
            $userViolence->date = Carbon::parse($request->date)->format('Y-m-d');
            $userViolence->location = $request->location;
            $userViolence->addiction_id = intval($request->addiction_id);
            $userViolence->weapons = $request->weapons;
            $userViolence->save();
            
            
            if ($request->typesviolences) {
                foreach ($request->typesviolences as $key => $typesviolence) {
                    UserViolenceField::create([
                     'user_violences_id' => $userViolence->id,
                     'typesviolence_id'=> $typesviolence["value"],
                     'fieldsviolence_id'=> $typesviolence["origin_id"]

                 ]);
            }

            }
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | caso de violencia registrado.';
            $response->data["alert_text"] = 'UserViolence registrado';
            $response->data["result"] = $userViolence->id;
        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function profileAgressor(Request $request, Response $response,int $id=null)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {


                $userData = UserData::where("user_violence", $id)->first();
                if (!$userData) {
                    
                    $userData = new UserData();
                    $userData->user_violence = $id;
                    $userViolence = new UserViolence();
                    $userViolence->user_datageneral_id = $id;
                    

                }
                else{
                    $userViolence = UserViolence::where("id", $userData->user_violence)->first();
                    // $userData = UserViolence::where("id", $id)->first();
                    // $id = intval($userData->user_datageneral_id);
                    // $userData = UserData::where("id", $id)->first();
                    
                }
                $userData->name = $request->name;
                $userData->lastName = $request->lastName;
                $userData->secondName = $request->secondName;
                $userData->sex = $request->sex;
                $userData->gender_id = intval($request->gender_id);
                $userData->birthdate = Carbon::parse($request->birthdate)->format('Y-m-d');
                $userData->age = $request->age;
                $userData->telephone = $request->telephone;
                $userData->save();
                
                $comunity = new UserComunityImmController();
                $comunity->create($request,$response,$userData->id,$userData->id);
                $this->createProfile($request,$response,$userData->id);
                $idreturn = UserViolence::where("id", $id)->first();
                    $id= intval($idreturn->user_datageneral_id);
                $response->data = ObjResponse::CorrectResponse();
                $response->data["message"] = 'peticion satisfactoria | datos del agresor registrados.';
                $response->data["alert_text"] = 'UserData registrada';
                $response->data["result"] = $id;
        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function createService(Request $request, Response $response,int $id)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $UserService = UserService::where("user_datageneral_id", $id)->first();
            if (!$UserService) {
                $UserService = new UserService();
                $id = intval($id);
                $UserService->user_datageneral_id = $id;
            }
            else{
                UserServicesReferences::where("user_service_id",$UserService->id)->delete();

            }
            // $UserService->workplace_id = intval($request->workplace_id);
            $UserService->subservice = $request->subservice;
            $UserService->axi_id = intval($request->axi_id);
            $UserService->axi_program_id = intval($request->axi_program_id);
            $UserService->lineacction = $request->lineacction;
            $UserService->observations = $request->observations;
            $UserService->status_id = intval($request->status_id);
            $UserService->save();
            if ($request->workplace_id) {
                foreach ($request->workplace_id as $key => $workplace) {
                    UserServicesReferences::create([
                     'user_service_id' => $UserService->id,
                     'services_id'=> $workplace["value"],
                 ]);
            }
        }

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | servicio registrado.';
            $response->data["alert_text"] = 'UserData registrada';
            $response->data["result"] = $UserService;

        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = UserData::where('user_datageneral.active', true)
            ->select('user_proceedings.procceding as folio', 'user_datageneral.id', 'user_datageneral.name as nombre', 'user_datageneral.lastName as apellido paterno', 'user_datageneral.secondName as apellido materno',
                'status.status as status')
            ->join('user_proceedings', 'user_proceedings.user_datageneral_id', '=', 'user_datageneral.id')
            ->join('user_services', 'user_services.user_datageneral_id', '=', 'user_datageneral.id')
            ->join('status', 'status.id', '=', 'user_services.status_id')
            ->orderBy('user_datageneral.id', 'asc')
            ->get();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de tipos de violencia.';
            $response->data["result"] = $list;

        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function destroy(int $id, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            UserData::where('id', $id)
            ->update([
                'active' => false,
                'deleted_at' => date('Y-m-d H:i:s'),
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | Usuario eliminado.';
            $response->data["alert_text"] ='Usuario eliminado';

        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function getData(Request $request, Response $response,int $id){
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = UserData::where('user_datageneral.id', $id)
            ->select(
                'user_datageneral.id',
                'user_datageneral.name',
                'user_datageneral.lastName',
                'user_datageneral.secondName',
                'user_datageneral.gender_id',
                'user_datageneral.sex',
                'user_datageneral.birthdate',
                'user_datageneral.age',
                'user_datageneral.telephone',
                'user_datageneral.email',
                'user_datageneral.civil_status_id',
                'user_datageneral.numberchildrens',
                'user_datageneral.numberdaughters',
                'user_datageneral.pregnant',
                'user_proceedings.procceding',
                'user_proceedings.timeingress',

                DB::raw("DATE_FORMAT(user_proceedings.dateingress, '%m/%d/%Y') AS dateingress"),
                'user_proceedings.timeingress',
                'user_comunities.street',
                'user_comunities.number',
                'user_comunities.colonies_id',
                'user_comunities.zone',
                'user_comunities.statebirth',
            )
            ->leftjoin('user_proceedings', 'user_proceedings.user_datageneral_id', '=', 'user_datageneral.id')
            ->leftjoin('user_comunities', 'user_comunities.user_datageneral_id', '=', 'user_datageneral.id')
            ->orderBy('user_datageneral.id', 'asc')
            ->get();


            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de tipos de violencia.';
            $response->data["result"] = $list;

        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function getProfile(Request $request, Response $response,int $id){
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = UserProfile::where('user_profiles.user_datageneral_id', $id)
            ->select(
                'user_profiles.activity_id',
                'user_profiles.sourceofincome',
                'user_profiles.workplace_id',
                'user_profiles.entry_time',
                'user_profiles.departure_time',
                'user_profiles.training_id',
                'user_profiles.finish',
                'user_profiles.wantofindwork',
                'user_profiles.wanttotrain',
                'user_profiles.wantocontinuestudying',
                'user_profiles.household_id',
                'user_profiles.caseviolence',
                DB::raw('GROUP_CONCAT(DISTINCT medicalservices.medicalservice,user_profiles_medicalservices.medicalservice_id,",",user_profiles_medicalservices.medicalservice_id) as medicalservices'),
                DB::raw('GROUP_CONCAT(DISTINCT addictions.addiction,user_profiles_adicttions.addiction_id,",",user_profiles_adicttions.addiction_id) as adicttions'),
                DB::raw('GROUP_CONCAT(DISTINCT diseases.diseas,user_diseases.diseas_id) as diseas_ids'),
                DB::raw('GROUP_CONCAT(DISTINCT diseases.diseas,user_diseases.diseas_id,"_description,",user_diseases.origin_id) as diseas_origin_id'),
                DB::raw('GROUP_CONCAT(DISTINCT disabilities.disability,disabilities.id) as disability_ids'),
                DB::raw('GROUP_CONCAT(DISTINCT disabilities.disability,disabilities.id,"_description,",user_disabilities.origin_id) as disability_origin_id')
            )
            ->leftJoin('user_disabilities', 'user_disabilities.user_datageneral_id', '=', 'user_profiles.user_datageneral_id')
            ->leftJoin('user_diseases', 'user_diseases.user_datageneral_id', '=', 'user_profiles.user_datageneral_id')
            ->leftJoin('diseases', 'diseases.id', '=', 'user_diseases.diseas_id')
            ->leftJoin('disabilities', 'disabilities.id', '=', 'user_disabilities.disability_id')
            ->leftJoin('user_profiles_adicttions', 'user_profiles_adicttions.user_profiles_id', '=', 'user_profiles.id')
            ->leftJoin('user_profiles_medicalservices', 'user_profiles_medicalservices.user_profiles_id', '=', 'user_profiles.id')
            ->leftJoin('medicalservices', 'medicalservices.id', '=', 'user_profiles_medicalservices.medicalservice_id')
            ->leftJoin('addictions', 'addictions.id', '=', 'user_profiles_adicttions.addiction_id')
            ->groupBy(
                'user_profiles.activity_id',
                'user_profiles.sourceofincome',
                'user_profiles.workplace_id',
                'user_profiles.entry_time', // Agrega esta columna a GROUP BY
                'user_profiles.departure_time',
                'user_profiles.training_id',
                'user_profiles.finish',
                'user_profiles.wantofindwork',
                'user_profiles.wanttotrain',
                'user_profiles.wantocontinuestudying',
                'user_profiles.household_id',
                'user_profiles.caseviolence',
              
            
            )
            ->get();
        


            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de tipos de violencia.';
            $response->data["result"] = $list;

        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function getViolence(Request $request, Response $response,int $id){
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = UserViolence::where('user_violences.user_datageneral_id', $id)
            ->select(
           
            'user_violences.lowefecct',
            'user_violences.narrationfacts',
            'user_violences.date',
            'user_violences.location',
            'user_violences.addiction_id',
            'user_violences.weapons',
            DB::raw('GROUP_CONCAT(DISTINCT typesviolences.violence,user_violence_fields.typesviolence_id) as user_violence_fields'),
             DB::raw('GROUP_CONCAT(DISTINCT typesviolences.violence,user_violence_fields.typesviolence_id,"_description,",user_violence_fields.fieldsviolence_id) as fieldsviolence_id')
            )
            ->leftjoin('user_violence_fields', 'user_violence_fields.user_violences_id', '=', 'user_violences.id')
            ->leftjoin('typesviolences', 'typesviolences.id', '=', 'user_violence_fields.typesviolence_id')
            ->leftjoin('fieldsviolences', 'fieldsviolences.id', '=', 'user_violence_fields.fieldsviolence_id')

            ->groupBy(
                'user_violences.id',
                'user_violences.lowefecct',
                'user_violences.narrationfacts',
                'user_violences.date',
                'user_violences.location',
                'user_violences.addiction_id',
                'user_violences.weapons',
                )
            ->orderBy('user_violences.id', 'asc')
            ->get();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de tipos de violencia.';
            $response->data["result"] = $list;

        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function getprofileAgressor(Request $request, Response $response,int $id){
        $response->data = ObjResponse::DefaultResponse();
        try {
            $id = UserViolence::where('user_violences.user_datageneral_id', $id)->first();
            $id = intval($id->id);

            $list = UserData::where('user_datageneral.user_violence', $id)
            ->select(
                'user_datageneral.name',
                'user_datageneral.lastName',
                'user_datageneral.secondName',
                'user_datageneral.gender_id',
                'user_datageneral.sex',
                'user_datageneral.birthdate',
                'user_datageneral.age',
                'user_comunities.street',
                'user_comunities.number',
                'user_comunities.colonies_id',
                'user_comunities.zone',
                'user_datageneral.telephone',
                'user_comunities.statebirth',
                'user_profiles.activity_id',
                'user_profiles.sourceofincome',
                'user_profiles.workplace_id',
                'user_profiles.entry_time',
                'user_profiles.departure_time',
                'user_profiles.household_id',
                DB::raw('GROUP_CONCAT(DISTINCT medicalservices.medicalservice,user_profiles_medicalservices.medicalservice_id,",",user_profiles_medicalservices.medicalservice_id) as medicalservices'),
                DB::raw('GROUP_CONCAT(DISTINCT addictions.addiction,user_profiles_adicttions.addiction_id,",",user_profiles_adicttions.addiction_id) as adicttions'),
                DB::raw('GROUP_CONCAT(DISTINCT diseases.diseas,user_diseases.diseas_id) as diseas_ids'),
                DB::raw('GROUP_CONCAT(DISTINCT diseases.diseas,user_diseases.diseas_id,"_description,",user_diseases.origin_id) as diseas_origin_id'),
                DB::raw('GROUP_CONCAT(DISTINCT disabilities.disability,disabilities.id) as disability_ids'),
                DB::raw('GROUP_CONCAT(DISTINCT disabilities.disability,disabilities.id,"_description,",user_disabilities.origin_id) as disability_origin_id')
            )
            ->leftjoin('user_comunities', 'user_comunities.user_datageneral_id', '=', 'user_datageneral.id')
            ->leftjoin('user_profiles', 'user_profiles.user_datageneral_id', '=', 'user_datageneral.id')
            ->leftjoin('user_disabilities', 'user_disabilities.user_datageneral_id', '=', 'user_profiles.user_datageneral_id')
            ->leftjoin('user_diseases', 'user_diseases.user_datageneral_id', '=', 'user_profiles.user_datageneral_id')
            ->leftjoin('diseases', 'diseases.id', '=', 'user_diseases.diseas_id')
            ->leftjoin('disabilities', 'disabilities.id', '=', 'user_disabilities.disability_id')
            ->leftjoin('user_profiles_adicttions', 'user_profiles_adicttions.user_profiles_id', '=', 'user_profiles.id')
            ->leftjoin('user_profiles_medicalservices', 'user_profiles_medicalservices.user_profiles_id', '=', 'user_profiles.id')
            ->leftjoin('medicalservices', 'medicalservices.id', '=', 'user_profiles_medicalservices.medicalservice_id')
            ->leftjoin('addictions', 'addictions.id', '=', 'user_profiles_adicttions.addiction_id')
            ->groupBy(
                'user_datageneral.id',
                'user_datageneral.name',
                'user_datageneral.lastName',
                'user_datageneral.secondName',
                'user_datageneral.gender_id',
                'user_datageneral.sex',
                'user_datageneral.birthdate',
                'user_datageneral.age',
                'user_comunities.street',
                'user_comunities.number',
                'user_comunities.colonies_id',
                'user_comunities.zone',
                'user_datageneral.telephone',
                'user_comunities.statebirth',
                'user_profiles.activity_id',
                'user_profiles.sourceofincome',
                'user_profiles.workplace_id',
                'user_profiles.entry_time',
                'user_profiles.departure_time',
                'user_profiles.household_id',
              
            )
            ->orderBy('user_datageneral.id', 'asc')
            ->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de tipos de violencia.';
            $response->data["result"] = $list;

        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function getServices(Request $request, Response $response,int $id){
        $response->data = ObjResponse::DefaultResponse();
        try {

            $list = UserService::where('user_services.user_datageneral_id', $id)
            ->select(
                'user_services.subservice',
                'user_services.axi_id',
                'user_services.axi_program_id',
                'user_services.lineacction',
                'user_services.observations',
                'user_services.status_id',
                DB::raw('GROUP_CONCAT(DISTINCT services.service,user_services_references.services_id,",",user_services_references.services_id) as workplaces'),

            )
            ->orderBy('user_services.id', 'asc')
            ->leftjoin('user_services_references', 'user_services_references.user_service_id', '=', 'user_services.id')
            ->leftjoin('services', 'services.id', '=', 'user_services_references.services_id')
            ->groupBy(
                'user_services.id',
               
              
            )
            ->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de servicios del usuario.';
            $response->data["result"] = $list;

        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function statusServiceProfile(Request $request, Response $response,int $iduser,int $idstatus){
        $response->data = ObjResponse::DefaultResponse();
        try {
            UserService::where('user_datageneral_id', $iduser)
            ->update([
                'status_id' => $idstatus,
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | Status Actualizado.';
            $response->data["alert_text"] ='Status Actualizado';

        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}
