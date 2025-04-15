<div class="row">
    <div class="col-12 col-md-6">
        <p>Contact Name : <b>{{$details['first_name'].' '.$details['last_name']}} </b></p>
    </div>
    <div class="col-12 col-md-6">
        <p>Company Name : <b> {{$details['profile']['company_name']}} </b></p>
    </div>
    <div class="col-12 col-md-6">
        <p>Company Business : <b> {{$details['profile']['business_name']}} </b></p>
    </div>
    <div class="col-12 col-md-6">
        <p>Company Email : <b> {{$details['email']}} </b></p>
    </div>
    <div class="col-12 col-md-6">
        <p>Phone Number : <b> {{$details['telephone']}} </b></p>
    </div>
    <div class="col-12 col-md-6">
        <p>Address Line1 : <b> {{$details['address1']}} </b></p>
    </div>
    <div class="col-12 col-md-6">
        <p>Address Line2 : <b> {{$details['address2']}} </b></p>
    </div>
    <div class="col-12 col-md-6">
        <p>>Country : <b> {{$details['country']['name']}} </b></p>
    </div>
    <div class="col-12 col-md-6">
        <p>State : <b> {{$details['state']['name']}} </b></p>
    </div>
    <div class="col-12 col-md-6">
       <p>Zip Code : <b> {{$details['postal']}} </b></p>
    </div>
    <div class="col-12">
        <form method="post" action="" id="approve_{{$details['id']}}">
        <div class="form-group">
            <label for="usr">Rejection:</label> 
            <input class="form-control" type="text" name="reject" id="reject" placeholder="Reason of rejection"/>
            <input type="hidden" name="id" id="id" value="{{$details['id']}}"/>
            <span id="errReason" class="error"></span>
        </div>
        </form>    
    </div>
    
</div>