using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace StudentManagement.Domain.Entities;

public class Attendance
{
    [Key]
    public int Id { get; set; }

    public int StudentId { get; set; }
    [ForeignKey("StudentId")]
    public Student Student { get; set; } = null!;

    public DateTime Date { get; set; }

    [Required, MaxLength(100)]
    public string SubjectName { get; set; } = string.Empty;

    [MaxLength(20)]
    public string ClassType { get; set; } = "lecture";

    public bool IsPresent { get; set; } = true;

    [MaxLength(255)]
    public string? ReasonForAbsence { get; set; }

    public int? MarkedBy { get; set; }
    [ForeignKey("MarkedBy")]
    public User? Marker { get; set; }
}
