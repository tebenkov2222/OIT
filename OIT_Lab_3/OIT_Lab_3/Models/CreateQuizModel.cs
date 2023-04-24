namespace OIT_Lab_3.Models;

public class CreateQuizModel
{
    public string Name { get; set; }
    public string Description { get; set; }
    public bool IsPrivate { get; set; }
    public string[] Answers { get; set; }
}