using Microsoft.EntityFrameworkCore;

namespace TestEF.DataBase;

public partial class PostgresContext : DbContext
{
    private DatabaseConfiguration _configuration = DatabaseConfiguration.Docker;
    public PostgresContext()
    {
    }

    public PostgresContext(DbContextOptions<PostgresContext> options)
        : base(options)
    {
    }

    public virtual DbSet<Answer> Answers { get; set; }

    public virtual DbSet<AnswersDatum> AnswersData { get; set; }

    public virtual DbSet<Quize> Quizes { get; set; }

    protected override void OnConfiguring(DbContextOptionsBuilder optionsBuilder) 
        => optionsBuilder.UseNpgsql(_configuration.ToString());

    protected override void OnModelCreating(ModelBuilder modelBuilder)
    {
        modelBuilder.Entity<Answer>(entity =>
        {
            entity.HasKey(e => e.AnswerId).HasName("answers_pkey");

            entity.ToTable("answers");

            entity.Property(e => e.AnswerId).HasColumnName("answer_id");
            entity.Property(e => e.Answer1)
                .IsRequired()
                .HasColumnName("answer");
            entity.Property(e => e.QuizId).HasColumnName("quiz_id");

            entity.HasOne(d => d.Quiz).WithMany(p => p.Answers)
                .HasForeignKey(d => d.QuizId)
                .OnDelete(DeleteBehavior.ClientSetNull)
                .HasConstraintName("answers_quiz_id_fkey");
        });

        modelBuilder.Entity<AnswersDatum>(entity =>
        {
            entity.HasKey(e => e.AnswerDataId).HasName("answers_data_pkey");

            entity.ToTable("answers_data");

            entity.Property(e => e.AnswerDataId).HasColumnName("answer_data_id");
            entity.Property(e => e.AnswerId).HasColumnName("answer_id");
            entity.Property(e => e.AnswerTime)
                .HasColumnType("timestamp without time zone")
                .HasColumnName("answer_time");
            entity.Property(e => e.Ip)
                .IsRequired()
                .HasColumnName("ip");

            entity.HasOne(d => d.Answer).WithMany(p => p.AnswersData)
                .HasForeignKey(d => d.AnswerId)
                .OnDelete(DeleteBehavior.ClientSetNull)
                .HasConstraintName("answers_data_answer_id_fkey");
        });

        modelBuilder.Entity<Quize>(entity =>
        {
            entity.HasKey(e => e.QuizId).HasName("quizes_pkey");

            entity.ToTable("quizes");

            entity.HasIndex(e => e.Uid, "quizes_uid_key").IsUnique();

            entity.Property(e => e.QuizId).HasColumnName("quiz_id");
            entity.Property(e => e.Description)
                .IsRequired()
                .HasColumnName("description");
            entity.Property(e => e.IsPrivate).HasColumnName("is_private");
            entity.Property(e => e.Name)
                .IsRequired()
                .HasColumnName("name");
            entity.Property(e => e.Uid)
                .IsRequired()
                .HasColumnName("uid");
        });

        OnModelCreatingPartial(modelBuilder);
    }

    partial void OnModelCreatingPartial(ModelBuilder modelBuilder);
}
