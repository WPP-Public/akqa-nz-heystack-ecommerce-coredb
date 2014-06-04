INSERT INTO `Heystack\DB\Zone` (ID, Created, LastEdited, Name)
  SELECT ID, Created, LastEdited, Name FROM AvailabilityZone;
