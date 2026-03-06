@extends('layouts.app')

@section('title', 'Список студентов')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Студенты</h1>
    <a href="{{ route('students.create') }}" class="btn btn-primary">Добавить студента</a>
</div>

<form method="GET" action="{{ route('students.index') }}" class="row g-3 mb-4">
    <div class="col-md-6">
        <input type="text" name="search" class="form-control" placeholder="Поиск по имени, коду, email" value="{{ $search }}">
    </div>
    <div class="col-md-4">
        <select name="group_id" class="form-select">
            <option value="">Все группы</option>
            @foreach($groups as $group)
                <option value="{{ $group['id'] }}" {{ $groupId == $group['id'] ? 'selected' : '' }}>
                    {{ $group['groupCode'] }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-secondary w-100">Применить</button>
    </div>
</form>

@if(count($students) > 0)
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Код</th>
                <th>ФИО</th>
                <th>Группа</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student['studentCode'] }}</td>
                <td>{{ $student['fullName'] }}</td>
                <td>{{ $student['groupName'] ?? '-' }}</td>
                <td>{{ $student['phone'] ?? '-' }}</td>
                <td>{{ $student['email'] ?? '-' }}</td>
                <td>
                    @if($student['status'] == 'active')
                        <span class="badge bg-success">Активен</span>
                    @elseif($student['status'] == 'expelled')
                        <span class="badge bg-danger">Отчислен</span>
                    @elseif($student['status'] == 'graduated')
                        <span class="badge bg-primary">Выпускник</span>
                    @else
                        <span class="badge bg-warning">{{ $student['status'] }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('students.show', $student['id']) }}" class="btn btn-sm btn-info">Просмотр</a>
                    <a href="{{ route('students.edit', $student['id']) }}" class="btn btn-sm btn-warning">Ред.</a>
                    <form action="{{ route('students.destroy', $student['id']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить?')">Уд.</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Простая пагинация -->
    <nav>
        <ul class="pagination">
            @for($i = 1; $i <= ceil($totalCount / 20); $i++)
                <li class="page-item {{ $i == $page ? 'active' : '' }}">
                    <a class="page-link" href="{{ route('students.index', ['page' => $i, 'search' => $search, 'group_id' => $groupId]) }}">{{ $i }}</a>
                </li>
            @endfor
        </ul>
    </nav>
@else
    <p class="text-muted">Студентов не найдено.</p>
@endif
@endsection
