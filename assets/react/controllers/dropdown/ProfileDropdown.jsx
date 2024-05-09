import { Menu, MenuHandler, MenuList, MenuItem, Button } from '@material-tailwind/react'
import React, { useState } from 'react'
import ProfessionalModal from '../modals/ProfessionalModal'

function ProfileDropdown({userId}) {
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
            <a href={`/profil/${userId}`}>
                <MenuItem>Profil</MenuItem>
            </a>
            <MenuItem onClick={setOpenModal}>Devenir professionnel</MenuItem>
        </MenuList>
        </Menu>

        <ProfessionalModal openModal={openModal} setOpenModal={setOpenModal} />
    </>
  )
}

export default ProfileDropdown