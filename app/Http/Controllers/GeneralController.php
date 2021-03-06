<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\UserFavorite;
use App\Models\User;
use App\Models\BusinessMessageLike;
use App\Models\BusinessImage;
use App\Models\BusinessReport;
use App\Models\BusinessMessageReply;
use App\Models\PersonalMessage;
use App\Models\BusinessItemPackage;
use App\Notifications\MessageEmailNotification;
use Auth;
use Config;
use Str;

class GeneralController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function deletePost(Request $request){

        $data = [];
        $data['message'] = '';
        $data['status'] = false;

        try{

            $table = $request->table;
            $id = $request->id;

            DB::delete('update '.$table.' set deleted_at = ? where id = ? ', [date(now()),$id]);

            $data['message'] = 'Deleted Successfully..!';
            $data['status'] = true;

        }catch(\Throwable $e){

            $data['message'] = $e->getMessage();

        }

        return $data;

    }

    public function deleteImage(Request $request){

        $data = [];
        $data['message'] = '';
        $data['status'] = false;

        try{

            BusinessImage::where('id',$request->id)->delete();

            $data['message'] = 'Deleted Successfully..!';
            $data['status'] = true;

        }catch(\Throwable $e){

            $data['message'] = $e->getMessage();

        }

        return $data;

    }

    public function getPostData(Request $request){

        $data = [];
        $data['message'] = '';
        $data['status'] = false;

        try{

            $table = $request->table;
            $id = $request->id;

            $className = 'App\\Models\\' . Str::studly(Str::singular($table));

            $response = $className::where('id',$id)->with('CoverImages')->first();

            $data['message'] = 'fetch Successfully..!';
            $data['response'] = $response;
            $data['status'] = true;

        }catch(\Throwable $e){

            $data['message'] = $e->getMessage();

        }

        return $data;

    }

    public function DoUnfav(Request $request){

        $data = [];
        $data['message'] = '';
        $data['status'] = false;

        try{

            $table = $request->table;
            $id = $request->id;

            $response = DB::select('select * from user_favorites where record_id = ? and model_table = ?', [$id,$table]);

            if($response[0]){

                DB::select('delete from user_favorites where record_id = ? and model_table = ?', [$id,$table]);

                $data['message'] = 'unfav Successfully..!';
                $data['status'] = true;

            }
            else{



            }

        }catch(\Throwable $e){

            $data['message'] = $e->getMessage();

        }

        return $data;

    }

    public function Dofav(Request $request){

        $data = [];
        $data['message'] = '';
        $data['status'] = false;

        try{

            $table = $request->table;
            $model = $request->model;
            $id = $request->id;

            UserFavorite::create([
                'model' => $model,
                'model_table' => $table,
                'record_id' => $id,
                'user_id' => Auth::user()->id,
            ]);

            $data['message'] = 'fav Successfully..!';
            $data['status'] = true;


        }catch(\Throwable $e){

            $data['message'] = $e->getMessage();

        }

        return $data;

    }

    public function LikeToggle($id,Request $request){

        if($request->like){

            BusinessMessageLike::where('business_message_id',$id)->where('user_id',Auth::user()->id)->delete();

        }else{

            BusinessMessageLike::create([
                'user_id' => Auth::user()->id,
                'business_message_id' => $id
            ]);
        }

        return redirect()->back();

    }

    public function Doreply($id,Request $request){

        BusinessMessageReply::create([
            'user_id' => Auth::user()->id,
            'business_message_id' => $id,
            'reply' => $request->message
        ]);

        return redirect()->back();
        
    }

    public function deleteReply($id,Request $request){

        BusinessMessageReply::where('id',$id)->delete();

        return redirect()->back();
        
    }

    public function sendMessage(Request $request){

        $data = [];
        $data['message'] = '';
        $data['status'] = false;
        DB::beginTransaction();

        try{

            $upload = $request->all();

            if($upload['body']){
                
                $upload['from_id'] = Auth::user()->id;

                PersonalMessage::create($upload);
                
                $user = User::where('id',$upload['to_id'])->first();

                if($user->user_type_id == Config::get('constants.UserTypeIds.Professional') || $user->user_type_id == Config::get('constants.UserTypeIds.User')){


                    if($request->table_name == 'BusinessDetail'){

                        $path = 'App\Models\User'.$request->table_name;

                    }else{

                        $path = 'App\Models\Business'.$request->table_name;
                    }


                    if($path == 'App\Models\UserBusinessDetail'){

                        $getData = $path::where('id',$request->table_record_id)->select('id','business_name as title')->first();
        
                    }
                    else{

                        $getData = $path::where('id',$request->table_record_id)->select('id','title')->first();

                    }

                    $EmailData = [
                        'email' => $user->email,
                        'title' => $getData->title,
                        'body' => $request->body,
                    ];

                    // $delay = now()->addMinutes(10);
                    // $user->notify((new MessageEmailNotification($EmailData))->delay($delay));
                    $user->notify(new MessageEmailNotification($EmailData));
                }


                $data['status'] = true;

            }

        }catch(\Throwable $e){

            DB::rollback();
            $data['message'] = $e->getMessage();

        }

        DB::commit();
        return $data;

    }

    public function getPackagePrice(Request $request){

        $package_id = $request->package_id;

        $package = BusinessItemPackage::where('id',$package_id)->first();

        return $package->amount;

    }

    public function reportUser(Request $request){

        $data = [];
        $data['message'] = '';
        $data['status'] = false;

        try{

            $UploadData = $request->all();

            if($UploadData['reported_to'] == Auth::user()->id){

                $data['message'] = 'Cannot report Oourself';
                $data['status'] = true;
            }else{

                $UploadData['reported_by'] = Auth::user()->id;

                $reported = BusinessReport::where('reported_by', Auth::user()->id)->where('reported_to', $request->reported_to)->first();

                if(!$reported){

                    BusinessReport::create($UploadData);

                    $data['message'] = 'Reported Successfully..!';
                    $data['status'] = true;
                
                }else{

                    $data['message'] = 'Already Reported..!';
                    $data['status'] = true;

                }
            }



        }catch(\Throwable $e){

            $data['message'] = $e->getMessage();

        }

        return $data;

    }

}

