using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using StudentManagement.Application.DTOs;
using StudentManagement.Domain.Entities;
using StudentManagement.Infrastructure.Data;

namespace StudentManagement.API.Controllers;

[Route("api/[controller]")]
[ApiController]
[Authorize]
public class StudentsController : ControllerBase
{
    private readonly AppDbContext _context;

    public StudentsController(AppDbContext context)
    {
        _context = context;
    }

    [HttpGet]
    public async Task<ActionResult<IEnumerable<StudentDto>>> GetStudents(
        [FromQuery] int page = 1,
        [FromQuery] int pageSize = 20,
        [FromQuery] string? search = null,
        [FromQuery] int? groupId = null)
    {
        var query = _context.Students
            .Include(s => s.Group)
            .AsNoTracking()
            .AsQueryable();

        if (!string.IsNullOrWhiteSpace(search))
        {
            query = query.Where(s =>
                s.FullName.Contains(search) ||
                s.StudentCode.Contains(search) ||
                (s.Email != null && s.Email.Contains(search)));
        }

        if (groupId.HasValue)
        {
            query = query.Where(s => s.GroupId == groupId);
        }

        var totalCount = await query.CountAsync();

        var students = await query
            .OrderBy(s => s.FullName)
            .Skip((page - 1) * pageSize)
            .Take(pageSize)
            .Select(s => new StudentDto
            {
                Id = s.Id,
                StudentCode = s.StudentCode,
                FullName = s.FullName,
                BirthDate = s.BirthDate,
                Gender = s.Gender,
                Phone = s.Phone,
                Email = s.Email,
                GroupId = s.GroupId,
                GroupName = s.Group != null ? s.Group.GroupCode : null,
                Status = s.Status,
                EnrollmentDate = s.EnrollmentDate
            })
            .ToListAsync();

        return Ok(new
        {
            items = students,
            totalCount,
            page,
            pageSize
        });
    }

    [HttpGet("{id}")]
    public async Task<ActionResult<StudentDto>> GetStudent(int id)
    {
        var student = await _context.Students
            .Include(s => s.Group)
            .FirstOrDefaultAsync(s => s.Id == id);

        if (student == null)
            return NotFound();

        return new StudentDto
        {
            Id = student.Id,
            StudentCode = student.StudentCode,
            FullName = student.FullName,
            BirthDate = student.BirthDate,
            Gender = student.Gender,
            Phone = student.Phone,
            Email = student.Email,
            GroupId = student.GroupId,
            GroupName = student.Group?.GroupCode,
            Status = student.Status,
            EnrollmentDate = student.EnrollmentDate
        };
    }

    [HttpPost]
    [Authorize(Roles = "admin,curator")]
    public async Task<ActionResult<StudentDto>> CreateStudent(CreateStudentDto dto)
    {
        var student = new Student
        {
            StudentCode = dto.StudentCode,
            FullName = dto.FullName,
            BirthDate = dto.BirthDate,
            Gender = dto.Gender,
            Phone = dto.Phone,
            Email = dto.Email,
            GroupId = dto.GroupId,
            EnrollmentDate = dto.EnrollmentDate,
            Status = "active"
        };

        _context.Students.Add(student);
        await _context.SaveChangesAsync();

        return CreatedAtAction(nameof(GetStudent), new { id = student.Id }, student);
    }

    [HttpPut("{id}")]
    [Authorize(Roles = "admin,curator")]
    public async Task<IActionResult> UpdateStudent(int id, UpdateStudentDto dto)
    {
        var student = await _context.Students.FindAsync(id);
        if (student == null)
            return NotFound();

        if (!string.IsNullOrWhiteSpace(dto.FullName))
            student.FullName = dto.FullName;
        if (!string.IsNullOrWhiteSpace(dto.Phone))
            student.Phone = dto.Phone;
        if (!string.IsNullOrWhiteSpace(dto.Email))
            student.Email = dto.Email;
        if (dto.GroupId.HasValue)
            student.GroupId = dto.GroupId;
        if (!string.IsNullOrWhiteSpace(dto.Status))
            student.Status = dto.Status;

        await _context.SaveChangesAsync();
        return NoContent();
    }

    [HttpDelete("{id}")]
    [Authorize(Roles = "admin")]
    public async Task<IActionResult> DeleteStudent(int id)
    {
        var student = await _context.Students.FindAsync(id);
        if (student == null)
            return NotFound();

        _context.Students.Remove(student);
        await _context.SaveChangesAsync();
        return NoContent();
    }
}
