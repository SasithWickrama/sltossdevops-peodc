<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Iptv_disconnection_feedback;
use App\Models\Iptv_disconnection_reason;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class CustomerFeedbackController extends Controller
{
    /* show the feedback user form */
    public function index(Request $request, $unique_id)
    {

        try{

            //check whether service order no exits or not
            $exResponseApi = Http::post('https://serviceportal.slt.lk/ApiPro/public/peoDcGetRecord', [
                'uid' => $unique_id,
            ]);
            $exJsonResponse = json_decode($exResponseApi->getBody()->getContents());

            if(!$exJsonResponse->error){
                $exits_ser_no = $exJsonResponse->data;
            
                if(empty($exits_ser_no)){
    
                    //return to slt website
                    return Redirect::to('https://www.slt.lk');  
                
                }else{
    
                    //check whether already response submitted or not
                    $responseApi =     Http::post('https://serviceportal.slt.lk/ApiPro/public/peoDcGetEmptyRecord', [
                                        'uid' => $unique_id,
                                    ]);
    
                    $jsonResponse = json_decode($responseApi->getBody()->getContents());
                    if(!$jsonResponse->error){

                        $jsonArrResponse = $jsonResponse->data;
                    
                        // if already response
                        if(empty($jsonArrResponse)){
        
                            $h2Text = "Already Responded!";
                            $h5Text = "Thank You For Your Response";
                            return view('customer.feedback_other', compact('h2Text','h5Text'));
        
                        }else{// if not response, save responce

                            $canResponse = (object)$jsonArrResponse[0];
                            return view('customer.feedback_form', compact('canResponse','unique_id'));
        
                        }

                    }else{

                        $notify_msg = array(
                            'responce' => false,
                            'message' => $jsonResponse->error,
                            'alert-type' => 'fail'
                        );

                    } 
    
                }  

            }else{

                $notify_msg = array(
                    'responce' => false,
                    'message' => $exJsonResponse->error,
                    'alert-type' => 'fail'
                );

            } 

        }catch (\Exception $ex) {//exception occured

            $msg = "Error Message :".$ex->getMessage();
            
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
            $responseApi =  Http::post('https://serviceportal.slt.lk/ApiPro/public/peoDcGetEmptyRecord', [
                'uid' => $unique_id,
            ]);
            $jsonResponse = json_decode($responseApi->getBody()->getContents());

            if(!$jsonResponse->error){ 

                $Response = $jsonResponse->data;   

                //if already response [$Response array empty?]
                if(empty($Response)){
    
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
                    
                    $upResponseApi = Http::post('https://serviceportal.slt.lk/ApiPro/public/peoDcUpdateRec', [
                        'uid' => $unique_id,
                        "cphandover" => $cp_handover,
                        "reason" => $disconnection_reason
                    ]);
                    $upJsonResponse = json_decode($upResponseApi->getBody()->getContents());
                    $updatefeedback = $upJsonResponse->data;
    
                    $notify_msg = array(
                        'responce' => $updatefeedback,
                        'message' => 'Response Updated Successfully!',
                        'alert-type' => 'success'
                    );
                }

            }else{
           
                $notify_msg = array(
                    'responce' => false,
                    'message' => $jsonResponse->error,
                    'alert-type' => 'fail'
                );

            } 

        }catch (\Exception $ex) {//Exception occured
            
           
            $msg = "Error Code :".$ex->getMessage();

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
            $responseApi = Http::post('https://serviceportal.slt.lk/ApiPro/public/peoDcReasonList');
            $jsonResponse = json_decode($responseApi->getBody()->getContents());

            if(!$jsonResponse->error){ 

                $reasons = $jsonResponse->data;

                $notify_msg = array(
                    'responce' => $reasons,
                    'message' => '',
                    'alert-type' => 'success'
                );
    

            }else{
           
                $notify_msg = array(
                    'responce' => false,
                    'message' => $exJsonResponse->error,
                    'alert-type' => 'fail'
                );

            } 
            
        }catch (\Exception $ex) {//Exception occured
                        
            $msg = "Error Code :".$ex->getMessage();

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
