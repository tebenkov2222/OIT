FROM mcr.microsoft.com/dotnet/aspnet:6.0 AS base
WORKDIR .

COPY OIT_Lab_3/bin/Release/net6.0/linux-x64/publish .

ENTRYPOINT ["dotnet", "OIT_Lab_3.dll"]