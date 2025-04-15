@extends('layouts.admin') @section('content')
<script src="{{asset('pages/admin/screening.js')}}"></script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1><?php if(@$details){?>Edit <?php }else{?> Add <?php }?> Question & Answer</h1>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/admin/screening-question-list')}}">Screening Question List</a></li>
                    <li class="breadcrumb-item active"> <?php if(@$details){?>Screening Question Edit <?php }else{?> Screening Question Add<?php }?> </li>
                </ol>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <div class="float-sm-right">
                    <a class="btn btn-info" href="{{url('/admin/screening-question-list')}}" title="Back to List">Back</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
       <div class="row">
            <div class="col-12">
                <!-- form start -->
                    <?php if(@$details){?>
                        <form role="form" method="post" id="addQuestion" action="{{ url('admin/screening-question-edit-post') }}">
                            <input type="hidden" name="master_id" value="{{@$details['id']}}"/>

                            <input type="hidden" name="multi_eng_id" value="{{ @$details['multiLangualQuestion'][0]['id']}}"/>
                            <input type="hidden" name="multi_frnch_id" value="{{ @$details['multiLangualQuestion'][1]['id']}}"/>
                            <input type="hidden" name="multi_por_id" value="{{ @$details['multiLangualQuestion'][2]['id']}}"/>

                            <input type="hidden" name="opt_eng_id" value="{{ @$details['answerOptions'][0]['id']}}"/>
                            <input type="hidden" name="opt_frnch_id" value="{{ @$details['answerOptions'][1]['id']}}"/>
                            <input type="hidden" name="opt_por_id" value="{{ @$details['answerOptions'][2]['id']}}"/>
                     <?php }else{?> 
                        <form role="form" method="post" id="addQuestion" action="{{ url('admin/screening-question-add-post') }}">
                      <?php }?>
                    
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"> <?php if(@$details){?>Edit <?php }else{?> Add <?php }?> Question & Answer</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <!-- /.card-body Account Details-->
                            <div class="card-body">
                                <div class="multi-question-div">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <h3 class="multi-question-heading"> English </h3>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="multi-question-inner">   
                                        <div class="row">    
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="title">Question</label>
                                                    <textarea placeholder="Question in English"  id="question_english" name="question_english" class="form-control"><?php if(@$details){ echo @$details['multiLangualQuestion'][0]['question'];}?></textarea>
                                                    @if ($errors->has('question_english'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('question_english') }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div> 
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="check-style">Option One
                                                        <input type="checkbox" name="answer" value="1" id="answer_one_1" class="radio" <?php if(@$details['answerOptions'][0]['answer'] == 1){ echo 'checked';}?>> 
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    @if ($errors->has('answer'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('answer') }}
                                                    </span>
                                                    @endif

                                                    <input type="text" name="option_one_english" class="form-control" placeholder="Option One in English" value="<?php if(@$details){ echo @$details['answerOptions'][0]['option_one'];}?>"/> 
                                                    @if ($errors->has('option_one_english'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('option_one_english') }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>    
                                            <div class="col-12 col-sm-6 col-md-6">    
                                                <div class="form-group">
                                                    <label for="title">Reason One</label>
                                                    <input type="text" name="reson_one_english" class="form-control" placeholder="Reason One in English" value="<?php if(@$details){ echo @$details['answerOptions'][0]['reason_one'];}?>"/> 
                                                    @if ($errors->has('reson_one_english'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('reson_one_english') }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="check-style">Option Two
                                                        <input type="checkbox" name="answer" value="2" id="answer_two_1" class="radio" <?php if(@$details['answerOptions'][0]['answer'] == 2){ echo 'checked';}?>> 
                                                        <span class="checkmark"></span>
                                                    </label>

                                                    <input type="text" name="option_two_english" class="form-control" placeholder="Option Two in English" value="<?php if(@$details){ echo @$details['answerOptions'][0]['option_two'];}?>"/>
                                                    @if ($errors->has('option_two_english'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('option_two_english') }}
                                                    </span>
                                                    @endif 
                                                </div>
                                            </div>    
                                            <div class="col-12 col-sm-6 col-md-6">    
                                                <div class="form-group">
                                                    <label for="title">Reason Two</label>
                                                    <input type="text" name="reson_two_english" class="form-control" placeholder="Reason Two in English" value="<?php if(@$details){ echo @$details['answerOptions'][0]['reason_two'];}?>"/>
                                                    @if ($errors->has('reson_two_english'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('reson_two_english') }}
                                                    </span>
                                                    @endif  
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="check-style">Option Three
                                                        <input type="checkbox" name="answer" value="3" id="answer_three_1" class="radio" <?php if(@$details['answerOptions'][0]['answer'] == 3){ echo 'checked';}?>> 
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <input type="text" name="option_three_english" class="form-control" placeholder="Option Three in English" value="<?php if(@$details){ echo @$details['answerOptions'][0]['option_three'];}?>"/>
                                                    @if ($errors->has('option_three_english'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('option_three_english') }}
                                                    </span>
                                                    @endif  
                                                </div>
                                            </div>  
                                            <div class="col-12 col-sm-6 col-md-6">  
                                                <div class="form-group">
                                                    <label for="title">Reason Three</label>
                                                    <input type="text" name="reson_three_english" class="form-control" placeholder="Reason Three in English" value="<?php if(@$details){ echo @$details['answerOptions'][0]['reason_three'];}?>"/> 
                                                    @if ($errors->has('reson_three_english'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('reson_three_english') }}
                                                    </span>
                                                    @endif 
                                                </div>
                                            </div>  
                                        </div>
                                    </div>    
                                </div>   
                                <div class="multi-question-div">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <h3 class="multi-question-heading"> French </h3>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="multi-question-inner">      
                                        <div class="row">    
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="title">Question</label>
                                                    <textarea placeholder="Question in French"  id="question_french" name="question_french" class="form-control"><?php if(@$details){ echo @$details['multiLangualQuestion'][1]['question'];}?></textarea>
                                                    @if ($errors->has('question_french'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('question_french') }}
                                                    </span>
                                                    @endif 
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="check-style">Option One
                                                        <input type="checkbox" name="answer" value="1" id="answer_one_2" class="radio" <?php if(@$details['answerOptions'][1]['answer'] == 1){ echo 'checked';}?>> 
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <input type="text" name="option_one_french" class="form-control" placeholder="Option One in French" value="<?php if(@$details){ echo @$details['answerOptions'][1]['option_one'];}?>"/> 
                                                    @if ($errors->has('option_one_french'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('option_one_french') }}
                                                    </span>
                                                    @endif 
                                                </div>
                                            </div>  
                                            <div class="col-12 col-sm-6 col-md-6">  
                                                <div class="form-group">
                                                    <label for="title">Reason One</label>
                                                    <input type="text" name="reson_one_french" class="form-control" placeholder="Reason One in French" value="<?php if(@$details){ echo @$details['answerOptions'][1]['reason_one'];}?>"/> 
                                                    @if ($errors->has('reson_one_french'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('reson_one_french') }}
                                                    </span>
                                                    @endif 
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="check-style">Option Two
                                                       <input type="checkbox" name="answer" value="2" id="answer_two_2" class="radio" <?php if(@$details['answerOptions'][1]['answer'] == 2){ echo 'checked';}?>> 
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <input type="text" name="option_two_french" class="form-control" placeholder="Option Two in French" value="<?php if(@$details){ echo @$details['answerOptions'][1]['option_two'];}?>"/> 
                                                    @if ($errors->has('option_two_french'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('option_two_french') }}
                                                    </span>
                                                    @endif 
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6">    
                                                <div class="form-group">
                                                    <label for="title">Reason Two</label>
                                                    <input type="text" name="reson_two_french" class="form-control" placeholder="Reason Two in French" value="<?php if(@$details){ echo @$details['answerOptions'][1]['reason_two'];}?>"/> 
                                                    @if ($errors->has('reson_two_french'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('reson_two_french') }}
                                                    </span>
                                                    @endif 
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="check-style">Option Three
                                                        <input type="checkbox" name="answer" value="3" id="answer_three_2" class="radio" <?php if(@$details['answerOptions'][1]['answer'] == 3){ echo 'checked';}?>>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <input type="text" name="option_three_french" class="form-control" placeholder="Option Three in French" value="<?php if(@$details){ echo @$details['answerOptions'][1]['option_three'];}?>"/> 
                                                    @if ($errors->has('option_three_french'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('option_three_french') }}
                                                    </span>
                                                    @endif 
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6">    
                                                <div class="form-group">
                                                    <label for="title">Reason Three</label>
                                                    <input type="text" name="reson_three_french" class="form-control" placeholder="Reason Three in French" value="<?php if(@$details){ echo @$details['answerOptions'][1]['reason_three'];}?>"/>
                                                    @if ($errors->has('reson_three_french'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('reson_three_french') }}
                                                    </span>
                                                    @endif  
                                                </div>
                                            </div>   
                                        </div>
                                    </div>    
                                </div>    
                                <div class="multi-question-div">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <h3 class="multi-question-heading"> Portuguese </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="multi-question-inner">    
                                        <div class="row">    
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="title">Question</label>
                                                    <textarea placeholder="Question in Portuguese"  id="question_portuguese" name="question_portuguese" class="form-control"><?php if(@$details){ echo @$details['multiLangualQuestion'][2]['question'];}?></textarea>
                                                    @if ($errors->has('question_portuguese'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('question_portuguese') }}
                                                    </span>
                                                    @endif 
                                                </div>
                                            </div> 
                                            <div class="col-12 col-sm-6 col-md-6"> 
                                                <div class="form-group">
                                                    <label class="check-style">Option One
                                                        <input type="checkbox" name="answer" value="1" id="answer_one_3"  class="radio" <?php if(@$details['answerOptions'][2]['answer'] == 1){ echo 'checked';}?>> 
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <input type="text" name="option_one_portuguese" class="form-control" placeholder="Option One in Portuguese" value="<?php if(@$details){ echo @$details['answerOptions'][2]['option_one'];}?>"/> 
                                                    @if ($errors->has('option_one_portuguese'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('option_one_portuguese') }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6">     
                                                <div class="form-group">
                                                    <label for="title">Reason One</label>
                                                    <input type="text" name="reson_one_portuguese" class="form-control" placeholder="Reason One in Portuguese" value="<?php if(@$details){ echo @$details['answerOptions'][2]['reason_one'];}?>"/> 
                                                    @if ($errors->has('reson_one_portuguese'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('reson_one_portuguese') }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6"> 
                                                <div class="form-group">
                                                    <label class="check-style">Option Two
                                                        <input type="checkbox" name="answer" value="2" id="answer_two_3" class="radio" <?php if(@$details['answerOptions'][2]['answer'] == 2){ echo 'checked';}?>>  
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <input type="text" name="option_two_portuguese" class="form-control" placeholder="Option Two in Portuguese" value="<?php if(@$details){ echo @$details['answerOptions'][2]['option_two'];}?>"/> 
                                                    @if ($errors->has('option_two_portuguese'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('option_two_portuguese') }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div> 
                                            <div class="col-12 col-sm-6 col-md-6">   
                                                <div class="form-group">
                                                    <label for="title">Reason Two</label>
                                                    <input type="text" name="reson_two_portuguese" class="form-control" placeholder="Reason Two in Portuguese" value="<?php if(@$details){ echo @$details['answerOptions'][2]['reason_two'];}?>"/> 
                                                    @if ($errors->has('reson_two_portuguese'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('reson_two_portuguese') }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6"> 
                                                <div class="form-group">
                                                    <label class="check-style">Option Three
                                                        <input type="checkbox" name="answer" value="3" id="answer_three_3" class="radio" <?php if(@$details['answerOptions'][2]['answer'] == 3){ echo 'checked';}?>>
                                                        <span class="checkmark"></span>  
                                                    </label>
                                                    <input type="text" name="option_three_portuguese" class="form-control" placeholder="Option Three in Portuguese" value="<?php if(@$details){ echo @$details['answerOptions'][2]['option_three'];}?>"/> 
                                                    @if ($errors->has('option_three_portuguese'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('option_three_portuguese') }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-6">     
                                                <div class="form-group">
                                                    <label for="title">Reason Three</label>
                                                    <input type="text" name="reson_three_portuguese" class="form-control" placeholder="Reason Three in Portuguese" value="<?php if(@$details){ echo @$details['answerOptions'][2]['reason_three'];}?>"/>
                                                    @if ($errors->has('reson_three_portuguese'))
                                                    <span class="error" role="alert">
                                                    {{ $errors->first('reson_three_portuguese') }}
                                                    </span>
                                                    @endif 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <!-- /.card-body Account Details-->
                            <div class="card-footer">
                                @csrf
                                <button type="submit" class="btn btn-primary" id="add-qsc"><?php if(@$details){?>Update <?php }else{?> Add <?php }?></button>
                            </div>
                        </div>
                    <!-- /.card -->
                </form>
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection