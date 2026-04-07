@extends('layouts.app')

@section('title', 'Карточка студента')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>{{ $student['fullName'] }}</h1>
    <div>
        <a href="{{ route('students.edit', $student['id']) }}" class="btn btn-warning">Редактировать</a>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Назад</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Код студента:</dt>
            <dd class="col-sm-9">{{ $student['studentCode'] }}</dd>

            <dt class="col-sm-3">ФИО:</dt>
            <dd class="col-sm-9">{{ $student['fullName'] }}</dd>

            <dt class="col-sm-3">Дата рождения:</dt>
            <dd class="col-sm-9">{{ $student['birthDate'] ?? 'не указано' }}</dd>

            <dt class="col-sm-3">Пол:</dt>
            <dd class="col-sm-9">{{ $student['gender'] == 'M' ? 'Мужской' : 'Женский' }}</dd>

            <dt class="col-sm-3">Телефон:</dt>
            <dd class="col-sm-9">{{ $student['phone'] ?? '-' }}</dd>

            <dt class="col-sm-3">Email:</dt>
            <dd class="col-sm-9">{{ $student['email'] ?? '-' }}</dd>

            <dt class="col-sm-3">Группа:</dt>
            <dd class="col-sm-9">{{ $student['groupName'] ?? 'не назначена' }}</dd>

            <dt class="col-sm-3">Статус:</dt>
            <dd class="col-sm-9">
                @if($student['status'] == 'active')
                    <span class="badge bg-success">Активен</span>
                @elseif($student['status'] == 'expelled')
                    <span class="badge bg-danger">Отчислен</span>
                @elseif($student['status'] == 'graduated')
                    <span class="badge bg-primary">Выпускник</span>
                @else
                    <span class="badge bg-warning">{{ $student['status'] }}</span>
                @endif
            </dd>

            <dt class="col-sm-3">Дата поступления:</dt>
            <dd class="col-sm-9">{{ $student['enrollmentDate'] ?? 'не указано' }}</dd>
        </dl>
    </div>
</div>
@endsection
