import { Menu, MenuHandler, MenuList, MenuItem, Button } from '@material-tailwind/react'
import React, { useEffect, useState } from 'react'
import ProfessionalModal from '../modals/ProfessionalModal'
import axios from 'axios';

function ProfileDropdown({userId}) {
    const [openModal, setOpenModal] = useState(false);
    const [professional, setProfessional] = useState();

    useEffect(() => {
        axios.get("/ajax/professional", {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => setProfessional(res.data))
        .catch(err => console.error(err));
    }, []);

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