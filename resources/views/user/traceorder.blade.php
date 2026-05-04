@extends('layouts.app')

@section('content')

            <div class="contact-form">
                        <form id="" action="/trace/confirm" method="post">
                            @csrf
                          <div class="">
                            <div class="col-lg-12">
                                <h1>Trace my order</h1>
                                <br>
                                <br>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                              <fieldset>
                                <input name="antrian" type="text" id="name" placeholder="Invoice no" required="">
                              </fieldset>
                            </div>
                            
                            <div class="col-lg-6 col-sm-12">
                              <fieldset>
                                <input name="phone" type="text" id="email" placeholder="Email" required="">
                              </fieldset>
                            </div>
                           
                           
                           
                            <div class="col-lg-6">
                              <fieldset>
                                <button type="submit" id="form-submit" class="main-button-icon">Submit</button>
                              </fieldset>
                            </div>
                          </div>
                        </form>
                    </div>
               
                    </center>
            

</div>
@endsection








<style>
.alert {
  padding: 20px;
  background-color: #f44336;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
</style>