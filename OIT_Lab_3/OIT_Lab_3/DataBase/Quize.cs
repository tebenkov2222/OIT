using System.Collections.Generic;

namespace TestEF.DataBase;

public partial class Quize
{
    public int QuizId { get; set; }

    public string Name { get; set; }

    public string Description { get; set; }

    public string Uid { get; set; }

    public bool IsPrivate { get; set; }

    public virtual ICollection<Answer> Answers { get; set; } = new List<Answer>();
}
