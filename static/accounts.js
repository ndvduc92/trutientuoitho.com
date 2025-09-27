// Global variables
var VTIndex = 0;
var VTimers = [];
var VTimerSpan = [];  
var VInterval;
var Vhour = [];
var Vmin = [];
var Vsec = [];
var VId = [];
var ExchRate = 0;
var ExchPoint = 0;
var ExchMaxG = 0;

// Initialize timer function that handles vote cooldowns
function StartGlobalTimer() {
    var VTimerFunc = setInterval(function () {
        for (i = 0; i < VTIndex; i++) { 
            if (VTimers[i] > 0) {
                // Calculate hours, minutes, and seconds
                Vhour[i] = parseInt(VTimers[i] / 3600, 10);
                Vmin[i] = parseInt((VTimers[i] - Vhour[i] * 3600) / 60, 10);
                Vsec[i] = parseInt(VTimers[i] % 60, 10);

                // Format display
                Vhour[i] = Vhour[i] < 10 ? "0" + Vhour[i] : Vhour[i];
                Vmin[i] = Vmin[i] < 10 ? "0" + Vmin[i] : Vmin[i];
                Vsec[i] = Vsec[i] < 10 ? "0" + Vsec[i] : Vsec[i];
                
                // Update display
                if (VTimerSpan[i]) {
                    VTimerSpan[i].innerHTML = Vhour[i] + ":" + Vmin[i] + ":" + Vsec[i];
                }
                VTimers[i]--;
            } else {
                if (VTimers[i] == 0) {
                    VTimers[i] = -1;
                    FinishedVoteTimer(VId[i]);
                }
            }
        }
    }, 1000);    
}

// Parse date string to Date object
function stringToDate(s) {
    try {
        var dateParts = s.split(' ')[0].split('-'); 
        var timeParts = s.split(' ')[1].split(':');
        var d = new Date(dateParts[0], --dateParts[1], dateParts[2]);
        d.setHours(timeParts[0], timeParts[1], timeParts[2]);
        return d;
    } catch (e) {
        console.error("Error parsing date:", e);
        return new Date();
    }
}

// Set up vote timers based on voting history
function SetVotTimers(dstack) {
    try {
        var dstck = dstack.split(",");
        var dv;
        var maxVOpt = 7;
        var stcki = dstck.length;
        var si = 0;
        var cDate = new Date;
        var diff;
        var cDat = cDate.getFullYear() + '-' + ("00" + (cDate.getMonth() + 1)).slice(-2) + '-' + ("00" + cDate.getDate()).slice(-2) + ' ' + 
                    ("00" + cDate.getHours()).slice(-2) + ':' + ("00" + cDate.getMinutes()).slice(-2) + ':' + ("00" + cDate.getSeconds()).slice(-2);
        
        VTIndex = 0;
        
        for (var i = 1; i <= maxVOpt; i++) {
            dv = document.getElementById('VoteRow' + i);
            if (dv != null) {
                VTIndex++;
                if (dstck[si] != null) {
                    if (dstck[si].length < 10) {
                        diff = 0;
                    } else {
                        diff = (VInterval * 3600) - parseInt((stringToDate(cDat) - stringToDate(dstck[si])) / 1000, 10);
                    }
                } else {
                    diff = 0;
                }
                
                NewVoteTimer(diff, VTIndex);
                si++;
                
                if (si >= dstck.length) {
                    si = 0;
                }
            }
        }
    } catch (e) {
        console.error("Error setting vote timers:", e);
    }
}

// Handle completed vote timer
function FinishedVoteTimer(voteid) {
    try {
        var div1 = document.getElementById(('VoteTimer' + voteid));
        if (div1) {
            // Modern button style
            div1.innerHTML = '<a href="javascript:void(0);" onclick="SendVoteData(' + voteid + ');" class="btn btn-primary btn-sm">Vote Now</a>';
        }
    } catch (e) {
        console.error("Error finishing vote timer:", e);
    }
}

// Set up a new vote timer
function NewVoteTimer(duration, voteid) {
    try {
        if (duration > 0) {
            VTimers[VTIndex] = duration;
            VId[VTIndex] = voteid;
            var timerSpan = document.getElementById(('VoteTimer' + voteid));
            if (timerSpan) {
                VTimerSpan[VTIndex] = timerSpan;
                VTIndex++;
            }
        } else {
            FinishedVoteTimer(voteid);
        }
    } catch (e) {
        console.error("Error creating new vote timer:", e);
    }
}

// Switch between account info and edit profile views
function SwitchDisplayDataDiv(x) {
    try {
        var accInfoDiv = document.getElementById("AccInfoDiv");
        var chngInfoDiv = document.getElementById("ChngInfoDiv");
        
        if (!accInfoDiv || !chngInfoDiv) return;
        
        if (x == 1) {
            // Switch to edit profile
            accInfoDiv.style.display = 'none';
            chngInfoDiv.style.display = 'block';
        } else if (x == 2) {
            // Switch back to account info
            accInfoDiv.style.display = 'block';
            chngInfoDiv.style.display = 'none';
        }
    } catch (e) {
        console.error("Error switching display:", e);
    }
}

// Send updated user data to server
function SendNewData() {
    try {
        var curUnam = document.getElementById('CurUnam');
        var curUId = document.getElementById('CurUId');
        var oldUnam = document.getElementById('OldUnam');
        var oldUId = document.getElementById('OldUId');
        var curPwd = document.getElementById('CurPwd');
        var newPwd1 = document.getElementById('NewPwd1');
        var newPwd2 = document.getElementById('NewPwd2');
        var mail = document.getElementById('Mail');
        var realName = document.getElementById('RealName');
        var dobYear = document.getElementById('dob-year');
        var dobMonth = document.getElementById('dob-month');
        var dobDay = document.getElementById('dob-day');
        var mstat = document.getElementById('mstat');
        var genderFemale = document.getElementById('gender_female');
        var genderMale = document.getElementById('gender_male');
        
        if (!curUnam || !curUId || !oldUnam || !oldUId || !curPwd || !newPwd1 || !newPwd2 || !mail || 
            !realName || !dobYear || !dobMonth || !dobDay || !mstat || !genderFemale || !genderMale) {
            console.error("One or more form elements not found");
            return;
        }
        
        var d1 = curUnam.value + "-" + curUId.value + "-" + oldUnam.value + "-" + oldUId.value;
        var d2 = curPwd.value + "-" + newPwd1.value + "-" + newPwd2.value;
        var d3 = mail.value;
        var d4 = realName.value;
        var d5 = 0;
        var d6 = dobYear.value + "-" + dobMonth.value + "-" + dobDay.value;
        var d7 = mstat.value;
        
        // Check gender selection
        if (genderFemale.checked) {
            d5 = 2;
        } else if (genderMale.checked) {
            d5 = 1;
        }
        
        // Send data to server
        SendDataWithAjax(13, [d1, d2, d3, d4, d5, d6, d7]);
    } catch (e) {
        console.error("Error sending new data:", e);
    }
}

// Calculate exchange cost for points to gold
function CheckExchCost() {
    try {
        setTimeout(function() {
            var ReqGoldInp = document.getElementById('ExchGAmount');
            if (!ReqGoldInp) return;
            
            var ReqGold = ReqGoldInp.value;
            var PCost;
            
            ReqGold = ReqGold.trim();
            if (ReqGold != parseInt(ReqGold)) {
                ReqGold = 0;
            }
            
            ReqGold = parseInt(ReqGold, 10);
            if (ExchMaxG > 99999) {
                ExchMaxG = 99999;
            }
            
            if (ReqGold > ExchMaxG) {
                ReqGold = ExchMaxG;
            }
            
            if (ReqGold < 0) {
                ReqGold = 0;
            }
            
            ReqGoldInp.value = parseInt(ReqGold, 10);
            PCost = ExchRate * ReqGold;
            PCost = parseInt(PCost, 10) || 0;
            
            var exchPCost = document.getElementById('ExchPCost');
            var exchGMinRes = document.getElementById('ExchGMinRes');
            var exchGMaxRes = document.getElementById('ExchGMaxRes');
            
            if (exchPCost) exchPCost.innerHTML = '<b>' + PCost + '</b>';
            if (exchGMinRes) exchGMinRes.innerHTML = '1';
            if (exchGMaxRes) exchGMaxRes.innerHTML = ExchMaxG;
        }, 300);
    } catch (e) {
        console.error("Error calculating exchange cost:", e);
    }
}

// Exchange points for gold
function ExchangePointToGold() {
    try {
        var ReqGold = parseInt(document.getElementById('ExchGAmount').value, 10) || 0;
        if (ReqGold > 0) {
            var exchangeDiv = document.getElementById('ExchangeDiv');
            if (exchangeDiv) exchangeDiv.style.display = 'none';
            
            SendDataWithAjax(14, [ReqGold]);
        } else {
            alert('Please enter a valid gold amount.');
        }
    } catch (e) {
        console.error("Error exchanging points to gold:", e);
    }
}

// Send vote data to server
function SendVoteData(voteid) {
    try {
        SendDataWithAjax(15, [voteid]);
    } catch (e) {
        console.error("Error sending vote data:", e);
    }
}