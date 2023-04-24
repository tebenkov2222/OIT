namespace TestEF.DataBase;

public class DatabaseConfiguration
{
    public string Host { get; set; }
    public int Port { get; set; }
    public string Database { get; set; }
    public string Username { get; set; }
    public string Password { get; set; }
    public override string ToString() => $"Host={Host};Port={Port};Database={Database};Username={Username};Password={Password}";

    public static DatabaseConfiguration Local => new DatabaseConfiguration()
    {
        Host = "localhost",
        Port = 8332,
        Database = "postgres",
        Username = "postgres",
        Password = "12345678",
    };
    public static DatabaseConfiguration Docker => new DatabaseConfiguration()
    {
        Host = "postgres",
        Port = 5432,
        Database = "postgres",
        Username = "postgres",
        Password = "12345678",
    };
}