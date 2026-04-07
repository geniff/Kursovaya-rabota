using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace StudentManagement.Domain.Entities;

public class Group
{
    [Key]
    public int Id { get; set; }

    [Required, MaxLength(20)]
    public string GroupCode { get; set; } = string.Empty;

    [MaxLength(100)]
    public string? GroupName { get; set; }

    public int? DepartmentId { get; set; }
    [ForeignKey("DepartmentId")]
    public Department? Department { get; set; }

    public int? CuratorId { get; set; }
    [ForeignKey("CuratorId")]
    public User? Curator { get; set; }

    public int StartYear { get; set; }
    public int EndYear { get; set; }

    [MaxLength(20)]
    public string Status { get; set; } = "active";

    public int StudentCount { get; set; } = 0;

    public ICollection<Student> Students { get; set; } = new List<Student>();
}
