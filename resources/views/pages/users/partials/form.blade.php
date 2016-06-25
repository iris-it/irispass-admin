<!--- lastname  Field --->
<div class="form-group">
    {!! Form::label('preferred_username', trans('user.username-field')) !!}
    {!! Form::text('preferred_username', null, ['id' => 'preferred_username' ,'class' => 'form-control']) !!}
</div>

<!--- lastname  Field --->
<div class="form-group">
    {!! Form::label('family_name', trans('user.lastname-field')) !!}
    {!! Form::text('family_name', null, ['id' => 'family_name' ,'class' => 'form-control']) !!}
</div>

<!--- firstname  Field --->
<div class="form-group">
    {!! Form::label('given_name', trans('user.firstname-field')) !!}
    {!! Form::text('given_name', null, ['id' => 'given_name' ,'class' => 'form-control']) !!}
</div>

<!--- Email Field --->
<div class="form-group">
    {!! Form::label('email', trans('user.email-field')) !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!---  Field --->
<div class="form-group">
    {!! Form::submit(trans('users.submit-create'), ['class' => 'btn btn-primary btn-flat pull-right', 'name' => 'submit-users-create']) !!}
</div>