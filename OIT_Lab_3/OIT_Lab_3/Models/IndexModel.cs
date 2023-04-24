using System.Collections.Generic;
using TestEF.DataBase;

namespace OIT_Lab_3.Models;

public class IndexModel
{
    public IEnumerable<Quize> PublicQuizes { get; set; }
}