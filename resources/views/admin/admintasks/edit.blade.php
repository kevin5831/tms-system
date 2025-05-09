@extends('admin.layouts.master')
@section('title', 'Edit Course Trigger')
@section('content')
<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Edit Course Trigger</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Course Trigger</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.coursetrigger.edit', $data->id) }}" method="POST" id="coursetriggeredit" enctype="multipart/form-data">
                    @csrf
                    <!-- <h5 class="card-header bg-secondary text-white mt-0">Edit Course</h5> -->
                    <div class="card-body">
                        <h4 class="header-title mt-0">Edit Course Trigger</h4>
                        <div class="row">

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="coursemain">Select Course <span class="text-danger">*</span></label>
                                    <select name="coursemain" id="coursemain" class="form-control select2">
                                        <option value="">Select Course</option>
                                        @foreach($courseMains as $courseMain)
                                        <option value="{{$courseMain->id}}" {{ $courseMain->id == $data->course_main_id ? 'selected' : '' }}>{{ $courseMain->name }} - {{ $courseMain->reference_number }}</option>
                                        @endforeach
                                    </select>
                                    @error('coursemain')
                                        <label class="form-text text-danger">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="event_when">Event When <span class="text-danger">*</span></label>
                                    <select name="event_when" id="event_when" class="form-control">
                                        <option value="">Select Event When</option>
                                        @foreach(triggerEventWhen() as $eventWhenKey => $eventWhen)
                                        <option value="{{$eventWhenKey}}" {{ $data->event_when == $eventWhenKey ? 'selected' : '' }}>{{ ucwords($eventWhen) }}</option>
                                        @endforeach
                                    </select>
                                    @error('event_when')
                                        <label class="form-text text-danger">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3" style="{{$data->event_when != 1 ? 'display:none;' : '' }}" id="noOfDaysDiv">
                                <label for="no_of_days">No Of Days <span class="text-danger">*</span></label>
                                <input type="text" name="no_of_days" id="no_of_days" class="form-control" value="{{ $data->no_of_days }}" onkeypress="return isNumberKey(event)" />
                                @error('no_of_days')
                                    <label class="form-text text-danger">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-md-3" style="{{$data->event_when != 2 ? 'display:none;' : '' }}" id="dateInMonthDiv">
                                <label for="date_in_month">Date in Month <span class="text-danger">*</span></label>
                                <select name="date_in_month" id="date_in_month" class="form-control select2">
                                    <option value="">Select Date in Month</option>
                                    @for($i = 1; $i < 29; $i++)
                                    <option value="{{$i}}" {{ $data->date_in_month == $i ? 'selected' : '' }}>{{ $i }} </option>
                                    @endfor
                                </select>
                                @error('date_in_month')
                                    <label class="form-text text-danger">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-md-3" style="{{$data->event_when != 3 ? 'display:none;' : '' }}" id="dayOfWeekDiv">
                                <label for="day_of_week">Day of Week <span class="text-danger">*</span></label>
                                <select name="day_of_week" id="day_of_week" class="form-control select2">
                                    <option value="">Select Day of Week</option>
                                    @foreach(getDaysOfWeek() as $dayKey => $dayName)
                                    <option value="{{$dayKey}}" {{ $data->day_of_week == $dayKey ? 'selected' : '' }}>{{ $dayName }}</option>
                                    @endforeach
                                </select>
                                @error('day_of_week')
                                    <label class="form-text text-danger">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="event_type">Event Type <span class="text-danger">*</span></label>
                                    <select name="event_type" id="event_type" class="form-control">
                                        <option value="">Select Event Type</option>
                                        @foreach(triggerEventTypes() as $eventTypeKey => $eventType)
                                        <option value="{{$eventTypeKey}}" {{ $data->event_type == $eventTypeKey ? 'selected' : '' }}>{{ ucwords($eventType) }}</option>
                                        @endforeach
                                    </select>
                                    @error('event_type')
                                        <label class="form-text text-danger">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12" style="{{$data->event_type != 3 && empty($data->task_text) ? 'display:none;' : '' }} {{$data->event_type == 3 ? '' : 'display:none;' }}" id="taskTextDiv">
                                <label for="task_text">Task Text <span class="text-danger">*</span></label>
                                <input name="task_text" id="task_text" class="form-control" value="{{ $data->task_text }}" />
                                @error('task_text')
                                    <label class="form-text text-danger">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-md-12" style="{{$data->event_type != 1 && empty($data->template_name) ? 'display:none;' : '' }} {{$data->event_type == 1 ? '' : 'display:none;' }}" id="emailTemplateDiv">
                                <label for="template_name">Select Email Template <span class="text-danger">*</span></label>
                                <select name="template_name" id="template_name" class="form-control select2">
                                    <option value="">Select Template</option>
                                    @foreach($templates->all() as $template)
                                    <option value="{{$template->template_name}}__!!__{{$template->template_slug}}" {{ $data->template_slug == $template->template_slug ? 'selected' : '' }}>{{ ucwords($template->template_name) }} - {{ $template->template_description }} </option>
                                    @endforeach
                                </select>
                                @error('template_name')
                                    <label class="form-text text-danger">{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="col-md-12" style="{{$data->event_type != 2 && empty($data->sms_template_id) ? 'display:none;' : '' }} {{$data->event_type == 2 ? '' : 'display:none;' }}" id="smsTemplateDiv">
                                <label for="sms_template">Select SMS Template <span class="text-danger">*</span></label>
                                <select name="sms_template" id="sms_template" class="form-control select2">
                                    <option value="">Select SMS Template</option>
                                    @foreach($smsTemplates as $smstemplate)
                                    <option value="{{$smstemplate->id}}" {{ $data->sms_template_id == $smstemplate->id ? 'selected' : '' }}>{{ ucwords($smstemplate->name) }} - {{ $smstemplate->description }} </option>
                                    @endforeach
                                </select>
                                @error('sms_template')
                                    <label class="form-text text-danger">{{ $message }}</label>
                                @enderror
                            </div>

                        </div>
                        <div class="row mt-4">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="custom-control custom-switch switch-success">
                                        <input type="checkbox" name="status" class="custom-control-input" id="status" {{ $data->status ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status">Status</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--end card-body-->
                    <div class="card-footer m-0 clearfix">
                        <button type="submit" class="btn btn-primary mar-r-10">Update</button>
                        <a href="{{ route('admin.coursetrigger.list') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
            </div><!--end card-->
        </div> <!--end col-->
    </div><!--end row-->

</div><!-- container -->
@endsection
@push("scripts")
<script type="text/javascript">
    $(document).ready(function() {
        $(".select2").select2({ width: '100%' });

        $(document).on('change', '#event_when', function(e) {
            let _val = $(this).val();
            $('#no_of_days').val('');
            $('#date_in_month').val('');
            $('#day_of_week').val('');
            if( _val == 1 ) {
                $('#dateInMonthDiv').hide();
                $('#dayOfWeekDiv').hide();
                $('#noOfDaysDiv').show();
            } else if( _val == 2 ) {
                $('#dayOfWeekDiv').hide();
                $('#noOfDaysDiv').hide();
                $('#dateInMonthDiv').show();
            } else if ( _val == 3 ) {
                $('#dateInMonthDiv').hide();
                $('#noOfDaysDiv').hide();
                $('#dayOfWeekDiv').show();
            }
            $(".select2").select2({ width: '100%' });
        });

        $(document).on('change', '#event_type', function(e) {
            let _val = $(this).val();
            $('#smsTemplateDiv').hide();
            $('#sms_template').val('');
            $('#taskTextDiv').hide();
            $('#task_text').val('');
            $('#emailTemplateDiv').hide();
            $('#template_name').val('');

            if( _val == 1 ) {
                $('#emailTemplateDiv').show();
            } else if( _val == 2 ) {
                $('#smsTemplateDiv').show();
            } else if( _val == 3 ) {
                $('#taskTextDiv').show();
            }
            $(".select2").select2({ width: '100%' });
        });

    });
</script>
@endpush
