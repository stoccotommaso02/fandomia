@echo off
setlocal enabledelayedexpansion

set source=1.jpg
set count=200  :: Number of copies to create

for /l %%i in (2,1,!count!) do (
    copy "%source%" "%%i.jpg"
)

echo Done!
