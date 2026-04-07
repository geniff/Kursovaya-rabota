namespace StudentManagement.Application.DTOs;

public class StudentDto
{
    public int Id { get; set; }
    public string StudentCode { get; set; } = string.Empty;
    public string FullName { get; set; } = string.Empty;
    public DateTime? BirthDate { get; set; }
    public string Gender { get; set; } = string.Empty;
    public string? Phone { get; set; }
    public string? Email { get; set; }
    public int? GroupId { get; set; }
    public string? GroupName { get; set; }
    public string Status { get; set; } = string.Empty;
    public DateTime EnrollmentDate { get; set; }
}

public class CreateStudentDto
{
    public string StudentCode { get; set; } = string.Empty;
    public string FullName { get; set; } = string.Empty;
    public DateTime? BirthDate { get; set; }
    public string Gender { get; set; } = string.Empty;
    public string? Phone { get; set; }
    public string? Email { get; set; }
    public int? GroupId { get; set; }
    public DateTime EnrollmentDate { get; set; } = DateTime.Now;
}

public class UpdateStudentDto
{
    public string? FullName { get; set; }
    public string? Phone { get; set; }
    public string? Email { get; set; }
    public int? GroupId { get; set; }
    public string? Status { get; set; }
}
