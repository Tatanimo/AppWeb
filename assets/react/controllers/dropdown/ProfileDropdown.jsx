import { Menu, MenuHandler, MenuList, MenuItem, Button } from '@material-tailwind/react'
import React, { useEffect, useState } from 'react'
import ProfessionalModal from '../modals/ProfessionalModal'

function ProfileDropdown({user, professional}) {
    const [openModal, setOpenModal] = useState(false);

  return (
    <>
        <Menu>
            <MenuHandler>
                <Button>
                    <img src="/img/icons/user_profile.svg"className="h-8"/>
                </Button>
            </MenuHandler>
            <MenuList>
                <a href={`/profil/${user.id}`}>
                    <MenuItem>Profil</MenuItem>
                </a>
                {!professional ? (
                    <MenuItem onClick={setOpenModal}>Devenir professionnel</MenuItem>
                ) : (
                    <a href={`/profil/professionnel/${professional.id}`}>
                        <MenuItem>Profil <span className='capitalize'>{professional.service.type}</span></MenuItem>
                    </a>
                )}
                <hr />
                <a href="/logout">
                    <MenuItem>Déconnexion</MenuItem>
                </a>
            </MenuList>
        </Menu>

        <ProfessionalModal openModal={openModal} setOpenModal={setOpenModal} />
    </>
  )
}

export default ProfileDropdown