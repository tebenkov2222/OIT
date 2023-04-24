using Microsoft.AspNetCore.Mvc;

namespace Oit_results.Controllers;

public class LabsController : Controller
{
    // GET
    public IActionResult Lab1()
    {
        return View();
    }    
    public IActionResult Lab2()
    {
        return View();
    }
}