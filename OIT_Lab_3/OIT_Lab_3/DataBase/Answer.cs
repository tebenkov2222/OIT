using System.Collections.Generic;

namespace TestEF.DataBase;

public partial class Answer
{
    public int AnswerId { get; set; }

    public int QuizId { get; set; }

    public string Answer1 { get; set; }

    public virtual ICollection<AnswersDatum> AnswersData { get; set; } = new List<AnswersDatum>();

    public virtual Quize Quiz { get; set; }
}
