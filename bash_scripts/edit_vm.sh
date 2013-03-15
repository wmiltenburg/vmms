#!/bin/bash
#Author: Wouter Miltenburg
mac="`cat /etc/libvirt/qemu/$1.xml | grep "mac address"`"
virsh destroy $1
virsh undefine $1
virt-install --connect qemu:///system -n $1 -r $2 --vcpus=$3 --disk path=/var/lib/libvirt/images/$1.img,size=$4 --import --vnc --noautoconsole --os-type linux --accelerate --network=bridge:br0 --hvm
$memory=$[$2*1024]
echo"
<domain type='kvm'>
  <name>$1</name>
  <uuid>5f4bc9e3-8776-f7df-9aeb-ffbb4852a4f5</uuid>
  <memory>$memory</memory>
  <currentMemory>$memory</currentMemory>
  <vcpu>$3</vcpu>
  <os>
    <type arch='x86_64' machine='pc-0.12'>hvm</type>
    <boot dev='hd'/>
  </os>
  <features>
    <acpi/>
    <apic/>
    <pae/>
  </features>
  <clock offset='utc'/>
  <on_poweroff>destroy</on_poweroff>
  <on_reboot>restart</on_reboot>
  <on_crash>restart</on_crash>
  <devices>
    <emulator>/usr/bin/kvm</emulator>
    <disk type='file' device='disk'>
      <driver name='qemu' type='raw'/>
      <source file='/var/lib/libvirt/images/vm1.img'/>
      <target dev='hda' bus='ide'/>
    </disk>
    <disk type='block' device='cdrom'>
      <driver name='qemu' type='raw'/>
      <target dev='hdc' bus='ide'/>
      <readonly/>
    </disk>
    <interface type='bridge'>
      $mac
      <source bridge='br0'/>
    </interface>
    <console type='pty'>
      <target port='0'/>
</console>
    <console type='pty'>
      <target port='0'/>
    </console>
    <input type='mouse' bus='ps2'/>
    <graphics type='vnc' port='-1' autoport='yes' keymap='en-us'/>
    <video>
      <model type='cirrus' vram='9216' heads='1'/>
    </video>
  </devices>
</domain>"