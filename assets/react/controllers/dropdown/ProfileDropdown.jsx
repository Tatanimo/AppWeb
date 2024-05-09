import { Menu, MenuHandler, MenuList, MenuItem, Button } from '@material-tailwind/react'
import React from 'react'

function ProfileDropdown({userInfo}) {
  return (
    <Menu>
      <MenuHandler>
        <Button>
            <img src="/img/icons/user_profile.svg"className="h-8"/>
        </Button>
      </MenuHandler>
      <MenuList>
        <a href={`/profil/${userInfo.id}`}>
            <MenuItem>Profil</MenuItem>
        </a>
        <MenuItem>Menu Item 2</MenuItem>
        <MenuItem>Menu Item 3</MenuItem>
      </MenuList>
    </Menu>
  )
}

export default ProfileDropdown