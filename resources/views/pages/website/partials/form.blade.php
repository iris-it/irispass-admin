<!--- username Field --->
<div class="form-group">
    {!! Form::label('username', trans('website.username-field')) !!}
    {!! Form::text('username', null, ['class' => 'form-control']) !!}
</div>

<!--- name Field --->
<div class="form-group">
    {!! Form::label('email', trans('website.email-field')) !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<!--- password Field --->
<div class="form-group">
    {!! Form::label('password', trans('website.password-field')) !!}
    <input class="form-control" name="password" type="password" id="password">
</div>


<!--- password_confirmation Field --->
<div class="form-group">
    {!! Form::label('password_confirmation', trans('website.password_confirmation-field')) !!}
    <input class="form-control" name="password_confirmation" type="password" id="password_confirmation">
</div>


<!---  Field --->
<div class="form-group">
    {!! Form::submit(trans('website.submit-create'), ['class' => 'btn btn-primary btn-flat', 'name' => 'submit-website-create']) !!}
</div>