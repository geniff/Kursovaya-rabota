@extends('layouts.app')

@section('title', 'Редактировать студента')

@section('content')
<h1>Редактировать: {{ $student['fullName'] }}</h1>

<form method="POST" action="{{ route('students.update', $student['id']) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="full_name" class="form-label">ФИО</label>
            <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name', $student['fullName']) }}">
            @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
            <label for="group_id" class="form-label">Группа</label>
            <select class="form-select" id="group_id" name="group_id">
                <option value="">-- Не выбрана --</option>
                @foreach($groups as $group)
                    <option value="{{ $group['id'] }}" {{ old('group_id', $student['groupId']) == $group['id'] ? 'selected' : '' }}>
                        {{ $group['groupCode'] }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="phone" class="form-label">Телефон</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $student['phone']) }}">
        </div>
        <div class="col-md-6 mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $student['email']) }}">
        </div>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Статус</label>
        <select class="form-select" id="status" name="status">
            <option value="active" {{ old('status', $student['status']) == 'active' ? 'selected' : '' }}>Активен</option>
            <option value="expelled" {{ old('status', $student['status']) == 'expelled' ? 'selected' : '' }}>Отчислен</option>
            <option value="graduated" {{ old('status', $student['status']) == 'graduated' ? 'selected' : '' }}>Выпускник</option>
            <option value="academic_leave" {{ old('status', $student['status']) == 'academic_leave' ? 'selected' : '' }}>Академ. отпуск</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Обновить</button>
    <a href="{{ route('students.show', $student['id']) }}" class="btn btn-secondary">Отмена</a>
</form>
@endsection
