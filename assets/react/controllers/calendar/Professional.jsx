import Calendar from 'react-calendar';
import React, { useEffect, useState } from 'react'
import 'react-calendar/dist/Calendar.css';
import axios from 'axios';

function isDateBetween(startDate, endDate, checkDate) {
  // Convertir les chaînes de caractères en objets Date
  const start = new Date(startDate);
  start.setHours(0);
  const end = new Date(endDate);
  end.setHours(0);
  const check = new Date(checkDate);
  check.setHours(0);

  // Comparer les dates
  return check >= start && check <= end;
}

function Professional({id}) {
  const [dateUnavailable, setDateUnavailable] = useState([]);
  useEffect(() => {
    axios.get(`/ajax/professional/schedules/${id}`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      }
    })
    .then(res => setDateUnavailable(res.data))
    .catch(err => console.error(err));
  }, []);
  
  const tileDisabled = ({date}) => {
    return dateUnavailable.some(element => {
      const a = new Date(element.unavailabilityStart);
      const b = new Date(element.unavailabilityEnd);
      return isDateBetween(a, b, date);
    });
  }

  console.log(dateUnavailable)

  return (
    <Calendar tileDisabled={tileDisabled} className={`border-none w-full [&>div:nth-child(1)]:justify-end [&>div:nth-child(1)]:relative [&>div:nth-child(1)>button:nth-child(1)]:hidden [&>div:nth-child(1)>button:nth-child(5)]:hidden [&>div:nth-child(1)>button:nth-child(3)]:flex-grow-0 [&>div:nth-child(1)>button:nth-child(3)]:absolute [&>div:nth-child(1)>button:nth-child(3)]:left-0 [&>div:nth-child(1)>button:nth-child(3)]:top-4 [&>div:nth-child(1)>button:nth-child(3)]:pointer-events-none [&>div:nth-child(1)>button:nth-child(3)>span]:font-serif [&>div:nth-child(1)>button:nth-child(3)>span]:font-semibold [&>div:nth-child(2)>div>div>div>div:nth-child(2)>button]:pointer-events-none [&>div:nth-child(2)>div>div>div>div:nth-child(1)>div>abbr]:no-underline [&>div:nth-child(2)>div>div>div>div:nth-child(2)>button]:rounded-xl [&>div:nth-child(2)>div>div>div>div:nth-child(2)>button]:aspect-square [&>div:nth-child(2)>div>div>div>div:nth-child(2)>button]:!flex-none [&>div:nth-child(2)>div>div>div>div:nth-child(2)>button]:h-12 [&>div:nth-child(2)>div>div>div>div:nth-child(2)]:gap-2 [&>div:nth-child(2)>div>div>div>div:nth-child(1)]:w-fit [&>div:nth-child(2)>div>div>div>div:nth-child(1)]:gap-[0.65rem]` } minDate={new Date()} />
  )
}

export default Professional