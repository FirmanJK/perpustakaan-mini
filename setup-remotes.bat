@echo off
echo =======================================
echo  Setup Remote Repositories
echo  MSJ Perpustakaan Project
echo =======================================
echo.

REM Input GitHub URL
echo [1/2] GitHub Setup
echo.
set /p github_url="Enter GitHub repository URL (e.g., https://github.com/username/msj-perpustakaan.git): "

if "%github_url%"=="" (
    echo ERROR: GitHub URL cannot be empty!
    pause
    exit /b 1
)

REM Input GitLab URL
echo.
echo [2/2] GitLab Setup
echo.
set /p gitlab_url="Enter GitLab repository URL (e.g., https://gitlab.com/username/msj-perpustakaan.git): "

if "%gitlab_url%"=="" (
    echo ERROR: GitLab URL cannot be empty!
    pause
    exit /b 1
)

echo.
echo =======================================
echo  Configuring Remotes...
echo =======================================

REM Remove existing remotes if any
git remote remove github 2>nul
git remote remove gitlab 2>nul
git remote remove origin 2>nul

REM Add GitHub remote
echo.
echo Adding GitHub remote...
git remote add github %github_url%

if errorlevel 1 (
    echo ERROR: Failed to add GitHub remote!
    pause
    exit /b 1
)
echo [32mGitHub remote added successfully![0m

REM Add GitLab remote
echo.
echo Adding GitLab remote...
git remote add gitlab %gitlab_url%

if errorlevel 1 (
    echo ERROR: Failed to add GitLab remote!
    pause
    exit /b 1
)
echo [32mGitLab remote added successfully![0m

REM Rename branch to main if needed
echo.
echo Setting up main branch...
git branch -M main

REM Show configured remotes
echo.
echo =======================================
echo  Configured Remotes:
echo =======================================
git remote -v

echo.
echo =======================================
echo  Setup completed successfully!
echo =======================================
echo.
echo Next steps:
echo 1. Make sure you have created empty repositories on GitHub and GitLab
echo 2. Run this command to push: push-all.bat "Initial commit"
echo 3. Or manually: git push github main ^&^& git push gitlab main
echo.
pause
