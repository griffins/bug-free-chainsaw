@extends('layouts.app')

@section('content')
  <div class="content">
    <div class="">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ module_route('accounts.update',$cron_job) }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('PUT')
            <div class="block ">
              <div class="block-header block-header-primary">
                <h4 class="block-title">{{ __('Edit Account') }}</h4>                
              </div>
              <div class="block-content ">
                <p class="block-category">{{ __('User information') }}</p>
                @include('components.forms.text',['field' => 'name','value' => $cron_job->name,])                
                @include('components.forms.radio',['field' => 'type','value' => $cron_job->type,'options'=> \App\Models\MaddenCronJobs::get_types() ])
                @include('components.forms.radio',['field' => 'frequency','value' => $cron_job->frequency,'options'=> \App\Models\MaddenCronJobs::get_frequencies() ])
                @include('components.forms.radio',['field' => 'status','value' => $cron_job->status,'options'=> \App\Models\MaddenCronJobs::get_statuses() ])                                
              </div>
              
              <div class="block-footer ">
                <button type="submit" class="btn btn-outline-primary ml-10 mb-10">{{ __('Save') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>      
    </div>
  </div>
@endsection