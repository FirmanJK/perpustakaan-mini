@echo off
echo =======================================
echo  Push MSJ Perpustakaan to GitHub and GitLab
echo =======================================
echo.

REM Check if remotes exist
git remote -v | findstr /C:"github" >nul
if errorlevel 1 (
    echo ERROR: Remote 'github' not found!
    echo Please setup remotes first. See SETUP_REMOTE.md
    pause
    exit /b 1
)

git remote -v | findstr /C:"gitlab" >nul
if errorlevel 1 (
    echo ERROR: Remote 'gitlab' not found!
    echo Please setup remotes first. See SETUP_REMOTE.md
    pause
    exit /b 1
)

REM Add all changes
echo Adding all changes...
git add .

REM Commit with message from argument or default message
if "%~1"=="" (
    set /p commit_msg="Enter commit message: "
    if "!commit_msg!"=="" (
        set commit_msg=Update: automated commit
    )
) else (
    set commit_msg=%*
)

echo.
echo Committing with message: %commit_msg%
git commit -m "%commit_msg%"

if errorlevel 1 (
    echo.
    echo No changes to commit or commit failed
    pause
    exit /b 1
)

REM Push to GitHub
echo.
echo =======================================
echo Pushing to GitHub...
echo =======================================
git push github main

if errorlevel 1 (
    echo.
    echo ERROR: Failed to push to GitHub!
    echo Please check your credentials and network connection
    pause
    exit /b 1
)

echo.
echo [32mGitHub push SUCCESS![0m

REM Push to GitLab
echo.
echo =======================================
echo Pushing to GitLab...
echo =======================================
git push gitlab main

if errorlevel 1 (
    echo.
    echo ERROR: Failed to push to GitLab!
    echo Please check your credentials and network connection
    pause
    exit /b 1
)

echo.
echo [32mGitLab push SUCCESS![0m

echo.
echo =======================================
echo  All pushes completed successfully!
echo =======================================
echo.
echo Repository synced to:
echo [36m- GitHub[0m
echo [36m- GitLab[0m
echo.
pause
