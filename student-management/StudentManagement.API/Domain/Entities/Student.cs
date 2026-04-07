using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace StudentManagement.Domain.Entities;

public class Student
{
    [Key]
    public int Id { get; set; }

    [Required, MaxLength(20)]
    public string StudentCode { get; set; } = string.Empty;

    [Required, MaxLength(100)]
    public string FullName { get; set; } = string.Empty;

    public DateTime? BirthDate { get; set; }

    [Required, MaxLength(1)]
    public string Gender { get; set; } = "M";

    [MaxLength(20)]
    public string? Phone { get; set; }

    [MaxLength(100)]
    public string? Email { get; set; }

    public int? GroupId { get; set; }
    [ForeignKey("GroupId")]
    public Group? Group { get; set; }

    [Required, MaxLength(20)]
    public string Status { get; set; } = "active";

    public DateTime EnrollmentDate { get; set; } = DateTime.Now;
    public DateTime? ExpulsionDate { get; set; }

    public ICollection<Parent> Parents { get; set; } = new List<Parent>();
    public ICollection<AcademicPerformance> Performances { get; set; } = new List<AcademicPerformance>();
    public ICollection<Attendance> Attendances { get; set; } = new List<Attendance>();
}
