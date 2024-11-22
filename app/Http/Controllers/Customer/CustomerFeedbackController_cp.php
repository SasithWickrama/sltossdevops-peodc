<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Iptv_disconnection_feedback;
use App\Models\Iptv_disconnection_reason;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;


class CustomerFeedbackController extends Controller
{
    /* show the feedback user form */
    public function index(Request $request, $unique_id)
    {

        try{

            //check whether service order no exits or not
            $exits_ser_no = Iptv_disconnection_feedback::where('UNIQUEID', $unique_id)->first();
            
            if($exits_ser_no === null){

                //return to slt website
                return Redirect::to('https://www.slt.lk');  
            
            }else{

                //check whether already response submitted or not
                $canResponse = Iptv_disconnection_feedback::where('UNIQUEID', $unique_id)
                                                            ->whereNull('DISCONNECTION_REASON')
                                                            ->whereNull('CP_HANDOVER')
                                                            ->first();
                // if already response
                if(is_null($canResponse)){

                    $h2Text = "Already Responded!";
                    $h5Text = "Thank You For Your Response";
                    return view('customer.feedback_other', compact('h2Text','h5Text'));

                }else{// if not response, save responce

                    return view('customer.feedback_form', compact('canResponse','unique_id'));

                }

            }    

        }catch (\Exception $ex) {//exception occured

            if($ex->getCode()){
                $msg = "Error Code :".$ex->getCode();
            }else{
                $msg = "Error Code :".$ex->getMessage();
            }
            
            $h2Text = "";
            $h5Text = $msg;
            return view('customer.feedback_other', compact('h2Text','h5Text'));
        }
    
    }

    /*submit feedback */
    public function update(Request $request)
    {

        //get parameters values from request
        $unique_id = $request->input('serviceorderno');
        $disconnection_reason = $request->input('disconnectionreason');
        $cp_handover = $request->input('cphandover');

        try{

            //check whether already response submitted or not
            $Response = Iptv_disconnection_feedback::where('UNIQUEID', $unique_id)
                                                    ->whereNull('DISCONNECTION_REASON')
                                                    ->whereNull('CP_HANDOVER')
                                                    ->get();

            //if already response [$Response array empty?]
            if($Response->isEmpty()){

                $notify_msg = array(
                    'responce' => false,
                    'message' => 'Already Responded',
                    'alert-type' => 'fail'
                );
                
            }else{// if not response, save responce

                $customerfeedback['DISCONNECTION_REASON'] = $disconnection_reason;
                $customerfeedback['CP_HANDOVER'] = $cp_handover;
                $customerfeedback['UPDATED_DATE'] =  DB::raw("SYSDATE");
                $customerfeedback['REPLY_DATE'] =  DB::raw("SYSDATE");
                $updatefeedback = Iptv_disconnection_feedback::where('UNIQUEID', $unique_id)->update($customerfeedback);   
    
                $notify_msg = array(
                    'responce' => $updatefeedback,
                    'message' => 'Response Updated Successfully!',
                    'alert-type' => 'success'
                );
            }

        }catch (\Exception $ex) {//Exception occured
            
            $msg = "Error Occured";
            if($ex->getCode()){
                $msg = "Error Code :".$ex->getCode();
            }else{
                $msg = "Error Code :".$ex->getMessage();
            }

            $notify_msg = array(
                'responce' => false ,
                'message' => $msg,
                'alert-type' => 'fail'
            );

        }

        //return response
        return Response()->json($notify_msg);

    }

    /*get reasons from tables*/
    public function get_reasons(Request $request)
    {

        try{

            // get all disconnection reasons
            $reasons = Iptv_disconnection_reason::orderBy('reason_id')->pluck('reason','reason_id');

            $notify_msg = array(
                'responce' => $reasons,
                'message' => '',
                'alert-type' => 'success'
            );

        }catch (\Exception $ex) {//Exception occured
            
            $msg = "Error Occured";
            if($ex->getCode()){
                $msg = "Error Code :".$ex->getCode();
            }else{
                $msg = "Error Code :".$ex->getMessage();
            }

            $notify_msg = array(
                'responce' => false ,
                'message' => $msg,
                'alert-type' => 'fail'
            );

        }

        //return response
        return Response()->json($notify_msg);

    }
    
}
