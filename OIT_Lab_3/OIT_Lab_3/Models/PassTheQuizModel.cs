using TestEF.DataBase;

namespace OIT_Lab_3.Models;

public class PassTheQuizModel
{
    public Quize Quize { get; set; }
    public bool IsAnswered { get; set; }
}