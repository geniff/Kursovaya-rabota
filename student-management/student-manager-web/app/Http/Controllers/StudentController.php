<?php
namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $search = $request->get('search', '');
        $groupId = $request->get('group_id');

        $response = $this->api->get('/students', [
            'page' => $page,
            'pageSize' => 20,
            'search' => $search,
            'groupId' => $groupId,
        ]);

        if (!$response['ok']) {
            return back()->withErrors('Ошибка загрузки студентов');
        }

        $students = $response['data']['items'] ?? [];
        $totalCount = $response['data']['totalCount'] ?? 0;

        // Получаем группы для фильтра
        $groupsResponse = $this->api->get('/groups');
        $groups = $groupsResponse['ok'] ? ($groupsResponse['data'] ?? []) : [];

        return view('students.index', compact('students', 'totalCount', 'page', 'search', 'groupId', 'groups'));
    }

    public function create()
    {
        $groupsResponse = $this->api->get('/groups');
        $groups = $groupsResponse['ok'] ? ($groupsResponse['data'] ?? []) : [];
        return view('students.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_code' => 'required|max:20',
            'full_name'    => 'required|max:100',
            'birth_date'   => 'nullable|date',
            'gender'       => 'required|in:M,F',
            'phone'        => 'nullable|max:20',
            'email'        => 'nullable|email|max:100',
            'group_id'     => 'nullable|integer',
            'enrollment_date' => 'nullable|date',
        ]);

        $response = $this->api->post('/students', $validated);

        if (!$response['ok']) {
            return back()->withInput()->withErrors('Ошибка сохранения');
        }

        return redirect()->route('students.index')->with('success', 'Студент добавлен');
    }

    public function show($id)
    {
        $response = $this->api->get("/students/{$id}");
        if (!$response['ok']) abort(404);
        return view('students.show', ['student' => $response['data']]);
    }

    public function edit($id)
    {
        $studentResponse = $this->api->get("/students/{$id}");
        if (!$studentResponse['ok']) abort(404);

        $groupsResponse = $this->api->get('/groups');
        $groups = $groupsResponse['ok'] ? ($groupsResponse['data'] ?? []) : [];

        return view('students.edit', [
            'student' => $studentResponse['data'],
            'groups' => $groups
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'full_name' => 'nullable|max:100',
            'phone'     => 'nullable|max:20',
            'email'     => 'nullable|email|max:100',
            'group_id'  => 'nullable|integer',
            'status'    => 'nullable|in:active,expelled,graduated,academic_leave',
        ]);

        $response = $this->api->put("/students/{$id}", $validated);

        if (!$response['ok']) {
            return back()->withInput()->withErrors('Ошибка обновления');
        }

        return redirect()->route('students.show', $id)->with('success', 'Данные обновлены');
    }

    public function destroy($id)
    {
        $response = $this->api->delete("/students/{$id}");
        if (!$response['ok']) {
            return back()->withErrors('Ошибка удаления');
        }
        return redirect()->route('students.index')->with('success', 'Студент удалён');
    }
}
