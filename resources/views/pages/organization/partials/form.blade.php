<!--- Date debut Field --->
<div class="form-group">
    {!! Form::label('name', trans('organization.name-field')) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!--- Date debut Field --->
<div class="form-group">
    {!! Form::label('address', trans('organization.address-field')) !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

<!--- Date debut Field --->
<div class="form-group">
    {!! Form::label('address_comp', trans('organization.address_comp-field')) !!}
    {!! Form::text('address_comp', null, ['class' => 'form-control']) !!}
</div>

<!--- Date debut Field --->
<div class="form-group">
    {!! Form::label('phone', trans('organization.phone-field')) !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<!--- Date debut Field --->
<div class="form-group">
    {!! Form::label('email', trans('organization.email-field')) !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!--- Date debut Field --->
<div class="form-group">
    {!! Form::label('website', trans('organization.website-field')) !!}
    {!! Form::text('website', null, ['class' => 'form-control']) !!}
</div>

<!---  Field --->
<div class="form-group">
    {!! Form::submit(trans('organization.submit-create'), ['class' => 'btn btn-primary', 'name' => 'submit-organization-create']) !!}
</div>