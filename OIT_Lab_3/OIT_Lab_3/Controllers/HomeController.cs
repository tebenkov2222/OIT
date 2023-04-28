using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using Microsoft.Extensions.Logging;
using OIT_Lab_3.Models;
using TestEF.DataBase;

namespace OIT_Lab_3.Controllers
{
    public class HomeController : Controller
    {
        private readonly ILogger<HomeController> _logger;
        private readonly PostgresContext _postgresContext;

        public HomeController(ILogger<HomeController> logger, PostgresContext postgresContext)
        {
            _logger = logger;
            _postgresContext = postgresContext;
        }

        public async Task<IActionResult> Index()
        {
            var publicQuizes = (from quiz in _postgresContext.Quizes
                where quiz.IsPrivate == false
                select quiz);
            var indexModel = new IndexModel();
            indexModel.PublicQuizes = publicQuizes;
            
            return View(indexModel);
            
        }
        [HttpGet]
        
        public IActionResult CreateQuiz()
        {
            return View();
        }
        [HttpGet]
        
        public IActionResult ErrorPassTheQuiz(ErrorPassTheQuizModel model)
        {
            return View(model);
        }
        [HttpGet]
        
        public async Task<IActionResult> ResultsQuiz(ShowQuizModel model)
        {
            var quize = await _postgresContext.Quizes.FirstOrDefaultAsync(q => q.Uid == model.QuizUid);

            var answers = (from answerContext in _postgresContext.Answers.Include(a => a.AnswersData)
                where answerContext.Quiz.Uid == model.QuizUid
                select answerContext);
            var fullCount = answers.Sum(t => t.AnswersData.Count());
            var answerResults = answers.Select(a => 
                new AnswerResult(){Answer = a.Answer1, Percent = ((float)a.AnswersData.Count() / (float)fullCount)})
                .OrderByDescending(t => t.Percent).ToList();

            return View(new ResuiltsQuizModel()
            {
                Answers = answerResults,
                FullCountAnswers = fullCount,
                Quize = quize
            });
        }
        
        [HttpGet]
        public async Task<IActionResult> PassTheQuiz(string uid)
        {
            Console.WriteLine($"Pass The Quiz. Uid = {uid}");
            var quize = await _postgresContext.Quizes.Include(q => q.Answers).FirstOrDefaultAsync(q => q.Uid == uid);
            if (quize == default)
            {
                return RedirectToAction("ErrorPassTheQuiz", new ErrorPassTheQuizModel()
                {
                    Uid = uid,
                    Log = $"Опрос с uid {uid} не найден"
                });
            }
            var isAnswered = await _postgresContext.AnswersData.AnyAsync(ad => ad.Answer.Quiz.Uid == uid && ad.Ip == GetIPAddress());

            return View(new PassTheQuizModel(){Quize = quize, IsAnswered = isAnswered});
        }
        [HttpPost]
        public async Task<IActionResult> SendAnswer(string uid, int answerId)
        {
            var ipAddress = GetIPAddress();
            Console.WriteLine($"Send Answer. uid = {uid} answerId = {answerId}, Ip={ipAddress}");
            var quize = await _postgresContext.Quizes.Include(q => q.Answers).FirstOrDefaultAsync(q => q.Uid == uid);
            if (quize == default)
            {
                return RedirectToAction("ErrorPassTheQuiz", new ErrorPassTheQuizModel()
                {
                    Uid = uid,
                    Log = $"Опрос с uid {uid} не найден"
                });
            }

            var answer = quize.Answers.FirstOrDefault(a => a.AnswerId == answerId);
            if (answer == default)
            {
                return RedirectToAction("ErrorPassTheQuiz", new ErrorPassTheQuizModel()
                {
                    Uid = uid,
                    Log = $"При обработке запроса произошла ошибка. Попробуйте еще раз."
                });
            }
            var findAnswer = await _postgresContext.AnswersData.FirstOrDefaultAsync(ad => (ad.Answer.Quiz.Uid == uid && ad.Ip == ipAddress));
            if (findAnswer != default)
            {
                _postgresContext.AnswersData.Remove(findAnswer);
            }
            var answerRes = new AnswersDatum(){AnswerId = answerId, AnswerTime = DateTime.Now, Ip = ipAddress};
            _postgresContext.AnswersData.Add(answerRes);
            await _postgresContext.SaveChangesAsync();
            return RedirectToAction("ResultsQuiz", new ShowQuizModel() {QuizUid = quize.Uid});;
        }
        protected string GetIPAddress()
        {
            Console.WriteLine($"Local = {HttpContext.Connection.LocalIpAddress}:{HttpContext.Connection.LocalPort}");
            Console.WriteLine($"Remote = {HttpContext.Connection.RemoteIpAddress}:{HttpContext.Connection.RemotePort}");
            var ipAddress = HttpContext.Connection.RemoteIpAddress + ":" + HttpContext.Connection.RemotePort;
            var s = ipAddress.ToString();
            return s;
        }
        [HttpGet]
        public async Task<IActionResult> CreatedQuiz(ShowQuizModel showQuiz)
        {
            var createQuizUid = showQuiz.QuizUid;
            var quize = await _postgresContext.Quizes.Include(q => q.Answers).FirstOrDefaultAsync(q => q.Uid == createQuizUid);
            return View(quize);
        }
        [HttpPost]
        public async Task<IActionResult> CreateQuiz(CreateQuizModel createQuizModel)
        {
            Console.WriteLine($"{createQuizModel.Name}");
            Console.WriteLine($"{createQuizModel.Description}");
            Console.WriteLine($"{createQuizModel.Answers}");
            if ((createQuizModel.Description == null ||createQuizModel.Description.Length < 3 || createQuizModel.Description.Length > 64) ||
                (createQuizModel.Name == null || createQuizModel.Name.Length < 3 || createQuizModel.Name.Length > 16) || 
                (createQuizModel.Answers == null || createQuizModel.Answers.Length < 2) ||
                (createQuizModel.Answers.Any(a => a.Length < 1 || a.Length > 16)))
            {
                return RedirectToAction("ErrorPassTheQuiz", new ErrorPassTheQuizModel()
                {
                    Log = $"При обработке запроса произошла ошибка. Попробуйте еще раз."
                });
            }
                        
            
            var uid = UidGenerator.GenerateUid(_postgresContext.Quizes.Count());
            Quize quize = new Quize() {Name = createQuizModel.Name, Description = createQuizModel.Description, Uid = uid, IsPrivate = createQuizModel.IsPrivate};
            _postgresContext.Quizes.Add(quize);
            await _postgresContext.SaveChangesAsync();
            List<Answer> answers = new List<Answer>();
            
            foreach (var inputAnswer in createQuizModel.Answers)
            {
                var answer = new Answer(){QuizId = quize.QuizId, Answer1 = inputAnswer};
                answers.Add(answer);
            }
            _postgresContext.Answers.AddRange(answers);
            await _postgresContext.SaveChangesAsync();
            return RedirectToAction("CreatedQuiz", new ShowQuizModel() {QuizUid = quize.Uid});
        }
        
        [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
        public IActionResult Error()
        {
            return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
        }
    }
}