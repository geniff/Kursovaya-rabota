using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace StudentManagement.Domain.Entities;

public class AcademicPerformance
{
    [Key]
    public int Id { get; set; }

    public int StudentId { get; set; }
    [ForeignKey("StudentId")]
    public Student Student { get; set; } = null!;

    [Required, MaxLength(100)]
    public string SubjectName { get; set; } = string.Empty;

    public int Semester { get; set; }

    [MaxLength(20)]
    public string ExamType { get; set; } = "exam";

    public int? Grade { get; set; }

    public bool? PassFail { get; set; }

    [MaxLength(100)]
    public string? TeacherName { get; set; }

    public DateTime ExamDate { get; set; }
}
