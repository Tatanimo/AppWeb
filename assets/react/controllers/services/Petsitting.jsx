import React, { useState } from 'react'
import SearchPetsitter from '../forms/SearchPetsitter'
import PetsitterCard from '../cards/PetsitterCard';

function Petsitting() {
    const [petsitters, setPetsitters] = useState([]);

  return (
    <>
        <div className="bg-beige w-full p-12 rounded-3xl">
            <SearchPetsitter onPetsitters={setPetsitters} />
        </div>
        <div className='grid xl:grid-cols-3 grid-cols-2 justify-items-center grid-rows-1 gap-5 mt-8'>
            {petsitters.map((e) => {
                const user = e[0];
                const dist = e[1];
                return(
                    <PetsitterCard key={user.id} user={user} dist={dist} />
                )
            })}
        </div>
    </>
  )
}

export default Petsitting