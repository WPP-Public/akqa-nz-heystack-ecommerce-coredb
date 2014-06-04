INSERT INTO `Heystack\DB\Currency` (`ID`, `Created`, `LastEdited`, `CurrencyCode`, `Value`, `Symbol`, `IsDefaultCurrency`)
  SELECT `ID`, `Created`, `LastEdited`, `CurrencyCode`, `Value`, `Symbol`, `IsDefaultCurrency`, Name FROM EcommerceCurrency;
