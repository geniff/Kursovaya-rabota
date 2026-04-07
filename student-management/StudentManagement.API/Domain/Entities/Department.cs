using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace StudentManagement.Domain.Entities;

public class Department
{
    [Key]
    public int Id { get; set; }

    [Required, MaxLength(10)]
    public string Code { get; set; } = string.Empty;

    [Required, MaxLength(100)]
    public string Name { get; set; } = string.Empty;

    public int? HeadId { get; set; }
    [ForeignKey("HeadId")]
    public User? Head { get; set; }

    [MaxLength(20)]
    public string? Phone { get; set; }

    [MaxLength(100)]
    public string? Email { get; set; }

    public ICollection<Group> Groups { get; set; } = new List<Group>();
}
