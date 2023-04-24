using System;

namespace TestEF.DataBase;

public partial class AnswersDatum
{
    public int AnswerDataId { get; set; }

    public int AnswerId { get; set; }

    public string Ip { get; set; }

    public DateTime AnswerTime { get; set; }

    public virtual Answer Answer { get; set; }
}
