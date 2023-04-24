using System.Collections.Generic;
using TestEF.DataBase;

namespace OIT_Lab_3.Models;

public class ResuiltsQuizModel
{
    public Quize Quize { get; set; }
    public int FullCountAnswers { get; set; }
    public List<AnswerResult> Answers { get; set; }
}

public class AnswerResult
{
    public string Answer { get; set; }
    public float Percent { get; set; }
}