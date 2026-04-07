@extends('layouts.app')

@section('title', 'Добавить студента')

@section('content')
<h1>Добавить студента</h1>

<form method="POST" action="{{ route('students.store') }}">
    @csrf

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="student_code" class="form-label">Код студента *</label>
            <input type="text" class="form-control @error('student_code') is-invalid @enderror" id="student_code" name="student_code" value="{{ old('student_code') }}" required>
            @error('student_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="full_name" class="form-label">ФИО *</label>
            <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
            @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="birth_date" class="form-label">Дата рождения</label>
            <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Пол *</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="gender_m" value="M" {{ old('gender')=='M' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="gender_m">Мужской</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="gender_f" value="F" {{ old('gender')=='F' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="gender_f">Женский</label>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="group_id" class="form-label">Группа</label>
            <select class="form-select" id="group_id" name="group_id">
                <option value="">-- Не выбрана --</option>
                @foreach($groups as $group)
                    <option value="{{ $group['id'] }}" {{ old('group_id') == $group['id'] ? 'selected' : '' }}>
                        {{ $group['groupCode'] }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="phone" class="form-label">Телефон</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
        </div>
    </div>

    <div class="mb-3">
        <label for="enrollment_date" class="form-label">Дата поступления</label>
        <input type="date" class="form-control" id="enrollment_date" name="enrollment_date" value="{{ old('enrollment_date', date('Y-m-d')) }}">
    </div>

    <button type="submit" class="btn btn-success">Сохранить</button>
    <a href="{{ route('students.index') }}" class="btn btn-secondary">Отмена</a>
</form>
@endsection
