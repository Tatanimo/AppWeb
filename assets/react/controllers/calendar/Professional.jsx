import Calendar from 'react-calendar';
import React, { useEffect, useState } from 'react'
import 'react-calendar/dist/Calendar.css';
import axios from 'axios';

function Professional({id, userId, appointment, onDateSelected}) {
  const [dateSelected, setDateSelected] = useState([]);
  const [dateUnavailable, setDateUnavailable] = useState([]);
  const [today, setToday] = useState(new Date())

  useEffect(() => {
    axios.get(`/ajax/professional/schedules/${id}`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      }
    })
    .then(res => setDateUnavailable(res.data))
    .catch(err => console.error(err));
  }, []);

  useEffect(() => {
    if (id == userId && dateSelected.length > 0 && !appointment) {
      axios.post(`/ajax/professional/schedules/${id}`, dateSelected, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
        }
      })
      .then(res => {
        setDateUnavailable(res.data)})
      .catch(err => console.error(err))
      .finally(() => document.activeElement.blur());
    } else if(appointment) {
      document.activeElement.blur();
      onDateSelected(dateSelected);
    }
  }, [dateSelected]);

  const tileClassName = ({date}) => {
    if (!appointment) {
      if(dateUnavailable.some(element => {
        const unavailable = new Date(element.unavailability);
        unavailable.setHours(0);
        const check = new Date(date);
        check.setHours(0);
  
        return check.toLocaleDateString() == unavailable.toLocaleDateString();
      })){
        return 'date-disabled';
      }
    } 
    else {
      if (dateSelected.length == 2) {
        const start = dateSelected[0];
        start.setHours(0);
        const end = dateSelected[1];
        end.setHours(0);
        const check = new Date(date);
        check.setHours(0);

        if (check >= start && check <= end) {
          if (dateUnavailable.some(element => {
            const unavailable = new Date(element.unavailability);
            unavailable.setHours(0);

            return check.toLocaleDateString() == unavailable.toLocaleDateString();
          })) {
            setDateSelected([]);
          } else {
            return 'date-selected'; 
          }
        }
      }
    }
  }

  const tileDisabled = ({date}) => {
    if (dateUnavailable.some(element => {
      const unavailable = new Date(element.unavailability);
      unavailable.setHours(0);
      const check = new Date(date);
      check.setHours(0);

      return check.toLocaleDateString() == unavailable.toLocaleDateString()
    })) {
      return true;
    }
    
  }

  return (
    <Calendar 
    activeStartDate={today} 
    tileClassName={tileClassName} 
    tileDisabled={appointment ? tileDisabled : null}
    selectRange={userId == id || appointment} 
    returnValue={"range"}
    onActiveStartDateChange={({ value, activeStartDate, action }) => {
      if (action === 'next') {
        setToday(new Date(activeStartDate))
      }
      if (action === 'prev') {
        setToday(new Date(activeStartDate))
      }
    }}      
    goToRangeStartOnSelect={true}
    onChange={(e) => setDateSelected(e)} 
    className={`min-w-96 max-w-96 border-none [&>div:nth-child(1)]:justify-end [&>div:nth-child(1)]:relative [&>div:nth-child(1)>button:nth-child(1)]:hidden [&>div:nth-child(1)>button:nth-child(5)]:hidden [&>div:nth-child(1)>button:nth-child(3)]:flex-grow-0 [&>div:nth-child(1)>button:nth-child(3)]:absolute [&>div:nth-child(1)>button:nth-child(3)]:left-0 [&>div:nth-child(1)>button:nth-child(3)]:top-4 [&>div:nth-child(1)>button:nth-child(3)]:pointer-events-none [&>div:nth-child(1)>button:nth-child(3)>span]:font-serif [&>div:nth-child(1)>button:nth-child(3)>span]:font-semibold ${userId == id || appointment ? null : "[&>div:nth-child(2)>div>div>div>div:nth-child(2)>button]:pointer-events-none"} [&>div:nth-child(2)>div>div>div>div:nth-child(1)>div>abbr]:no-underline [&>div:nth-child(2)>div>div>div>div:nth-child(2)>button]:rounded-xl [&>div:nth-child(2)>div>div>div>div:nth-child(2)>button]:aspect-square [&>div:nth-child(2)>div>div>div>div:nth-child(2)>button]:!flex-none [&>div:nth-child(2)>div>div>div>div:nth-child(2)>button]:h-12 [&>div:nth-child(2)>div>div>div>div:nth-child(2)]:gap-2 [&>div:nth-child(2)>div>div>div>div:nth-child(1)]:w-fit [&>div:nth-child(2)>div>div>div>div:nth-child(1)]:gap-[0.65rem]` } 
    minDate={new Date()} />
  )
}

export default Professional