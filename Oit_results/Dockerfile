FROM mcr.microsoft.com/dotnet/aspnet:6.0 AS base
WORKDIR .

COPY Oit_results/bin/Release/net6.0/linux-x64/publish .

ENTRYPOINT ["dotnet", "Oit_results.dll"]